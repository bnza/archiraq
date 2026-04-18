<?php

namespace App\Service\Import;

use App\Entity\ContributeEntity;
use App\Entity\Geom\SiteBoundaryEntity;
use App\Entity\SiteChronologyEntity;
use App\Entity\SiteEntity;
use App\Entity\SiteSurveyEntity;
use App\Event\ImportProgressEvent;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GeoJsonlImporter
{
    private $registry;
    private $em;
    private $parser;
    private $mapper;
    private $dispatcher;
    private $validator;

    public function __construct(
        EntityManagerInterface $em,
        GeoJsonlParser $parser,
        FeatureDtoToEntityMapper $mapper,
        EventDispatcherInterface $dispatcher,
        ManagerRegistry $registry,
        ValidatorInterface $validator
    ) {
        $this->registry = $registry;
        $this->em = $em;
        $this->parser = $parser;
        $this->mapper = $mapper;
        $this->dispatcher = $dispatcher;
        $this->validator = $validator;
    }

    /**
     * @param string $file
     * @param string|null $type
     * @param array $metadata
     * @param bool $dryRun
     * @param int $batchSize
     * @param callable|null $progressCallback
     * @return ImportResult
     */
    public function import(
        string $file,
        ?string $type,
        array $metadata,
        bool $dryRun = false,
        int $batchSize = 50,
        ?callable $progressCallback = null
    ): ImportResult {
        if (!file_exists($file)) {
            throw new \RuntimeException("File not found: $file");
        }

        // Clear any cached entities from previous imports to avoid detached entity issues
        $this->mapper->resetEntityManager($this->em);

        $this->em->getConnection()->beginTransaction();

        try {
            $contribute = new ContributeEntity();
            $contribute->setEmail($metadata['email'] ?? '');
            if (isset($metadata['contributor'])) $contribute->setContributor($metadata['contributor']);
            if (isset($metadata['institution'])) $contribute->setInstitution($metadata['institution']);
            if (isset($metadata['description'])) $contribute->setDescription($metadata['description']);
            $contribute->setStatus(1); // Assuming 1 means validated/imported
            $contribute->setSha1(sha1_file($file));

            if (!$dryRun) {
                try {
                    $this->em->persist($contribute);
                    $this->em->flush(); // Flush once to get the ID for validation purposes
                } catch (\Exception $e) {
                    if ($this->em->getConnection()->isTransactionActive()) {
                        $this->em->getConnection()->rollBack();
                    }
                    throw new \RuntimeException("Failed to create import record (maybe file was already imported?): " . $e->getMessage());
                }
            }

            $count = 0;
            $errors = [];
            $batchEntryIds = []; // Track entry_ids in current file to catch duplicates before flush
            foreach ($this->parser->parse($file, $type) as $dto) {
                $count++;
                
                try {
                    $entryId = $dto->entry_id;
                    if ($entryId && isset($batchEntryIds[$entryId])) {
                        $errors[] = [
                            'record' => $entryId ?? "Line $count",
                            'message' => "entry_id: Duplicate entry id $entryId found within the same import file"
                        ];
                        continue;
                    }

                    // Track entry_id as seen before mapping/validation so duplicates are caught even if this entry fails
                    if ($entryId) {
                        $batchEntryIds[$entryId] = true;
                    }

                    $site = $this->mapper->map($dto, $contribute);

                    // Validation
                    $violations = $this->validator->validate($site);
                    if (count($violations) > 0) {
                        $messages = [];
                        foreach ($violations as $violation) {
                            $messages[] = $violation->getPropertyPath() . ': ' . $violation->getMessage();
                        }
                        $errors[] = [
                            'record' => $dto->entry_id ?? "Line $count",
                            'message' => implode('; ', $messages)
                        ];
                        continue;
                    }

                    if (!$dryRun) {
                        $this->em->persist($site);

                        if ($count % $batchSize === 0) {
                            try {
                                $this->em->flush();
                                $this->em->clear(SiteEntity::class);
                                $this->em->clear(SiteChronologyEntity::class);
                                $this->em->clear(SiteSurveyEntity::class);
                                $this->em->clear(SiteBoundaryEntity::class);
                                $contribute = $this->em->merge($contribute);
                                // We keep batchEntryIds to catch duplicates within the same file even across batches
                            } catch (\Exception $flushEx) {
                                $errors[] = [
                                    'record' => "Batch up to line $count",
                                    'message' => "Database error during batch flush: " . $flushEx->getMessage()
                                ];
                                // If flush fails, the transaction is poisoned. We must stop.
                                break;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $errors[] = [
                        'record' => $dto->entry_id ?? "Line $count",
                        'message' => $e->getMessage()
                    ];
                }

                if ($progressCallback && $count % 100 === 0) {
                    $progressCallback($count);
                }
            }

            if (!empty($errors)) {
                if ($this->em->getConnection()->isTransactionActive()) {
                    $this->em->getConnection()->rollBack();
                }
                return new ImportResult(false, $count, $errors);
            }

            if (!$dryRun) {
                $this->em->flush();
                $this->em->getConnection()->commit();

                $this->dispatcher->dispatch(ImportProgressEvent::REFRESH_STARTED, new ImportProgressEvent('Refreshing materialized view...'));
                $this->em->getConnection()->executeUpdate("SELECT geom.refresh_mat_site()");
                $this->dispatcher->dispatch(ImportProgressEvent::REFRESH_FINISHED, new ImportProgressEvent('Refresh complete.'));
            } else {
                $this->em->getConnection()->rollBack();
            }

            return new ImportResult(true, $count);
        } catch (\Exception $e) {
            if ($this->em->getConnection()->isTransactionActive()) {
                $this->em->getConnection()->rollBack();
            }
            throw $e;
        }
    }
}

class ImportResult
{
    public $success;
    public $count;
    public $errors;

    public function __construct(bool $success, int $count, array $errors = [])
    {
        $this->success = $success;
        $this->count = $count;
        $this->errors = $errors;
    }
}
