<?php

namespace App\Controller;

use Bnza\JobManagerBundle\Exception\JobManagerEntityNotFoundException;
use Bnza\JobManagerBundle\Info\JobInfo;
use Bnza\JobManagerBundle\ObjectManager\ObjectManagerInterface;
use Bnza\JobManagerBundle\Serializer\JobConverter;
use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Runner\Job\AbstractImportSitesZipShapefileJob;
use App\Entity\ContributeEntity;
use App\Runner\Job\FullImportPublishedSitesZipShapefileJob;
use App\Runner\Job\FullImportRemoteSensingZipShapefileJob;
use App\Runner\Job\ImportFileJobFactory;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class JobController
{
    use JsonResponseControllerTrait;

    /**
     * @var ObjectManagerInterface
     */
    private $om;

    protected function getContributeFile(Request $request): UploadedFile
    {
        $file = $request->files->get('contributeFile');

        if (empty($file)) {
            $this->setStatusCode(422);
            $this->respondWithErrors('No file specified');
        }

        return $file;
    }

    protected function setUpContribute(Request $request, string $id): ?ContributeEntity
    {
        if ($contributeData = $request->request->get('contributeData')) {
            $contributeData = json_decode($contributeData, true);
            $serializer = new Serializer([new GetSetMethodNormalizer()]);
            $contribute = $serializer->denormalize($contributeData, ContributeEntity::class);
            $contribute->setSha1($id);

            return $contribute;
        }
        return null;
    }

    protected function setUpJob(Request $request, ImportFileJobFactory $factory, string $className, string $id)
    {
        $file = $this->getContributeFile($request);
        /** @var AbstractImportSitesZipShapefileJob $job */
        $job = $factory->create($className, $id);
        if ($contribute = $this->setUpContribute($request, $id)) {
            $job->setContribute($contribute);
        }
        $job->setSourceZipShapefilePath($file->getPathname());

        return $job;
    }

    protected function runJob(JobInterface $job)
    {
        try {
            $job->run();

            return $this->respond('done');
        } catch (\Exception $e) {
            $this->setStatusCode(500);

            return $this->respondWithErrors($e->getMessage());
        }
    }

    protected function setUpAndRunImportJob(
        Request $request,
        ImportFileJobFactory $factory,
        AuthorizationCheckerInterface $checker,
        SessionInterface $session,
        string $className,
        string $id
    ) {
        if (!$checker->isGranted('ROLE_EDITOR')) {
            $this->setStatusCode(403);
            $this->respondWithErrors('Access Denied.');
        }
        $job = $this->setUpJob($request, $factory, $className, $id);

        // Symfony doesn't allow concurrent session requests so session must be close as soon as possible
        // https://stackoverflow.com/questions/47911808/symfony-not-serving-concurrent-requests
        $session->save();

        return $this->runJob($job);
    }

    public function __construct(
        ObjectManagerInterface $om
    ) {
        $this->om = $om;
    }

    public function generateId()
    {
        return $this->respond(bin2hex(random_bytes(20)));
    }

    public function fullImportPublishedSitesZipShapefile(
        Request $request,
        ImportFileJobFactory $factory,
        AuthorizationCheckerInterface $checker,
        SessionInterface $session,
        string $id
    ) {
        return $this->setUpAndRunImportJob(
            $request,
            $factory,
            $checker,
            $session,
            FullImportPublishedSitesZipShapefileJob::class,
            $id);
    }

    public function fullImportRemoteSensingSitesZipShapefile(
        Request $request,
        ImportFileJobFactory $factory,
        AuthorizationCheckerInterface $checker,
        SessionInterface $session,
        string $id
    ) {
        return $this->setUpAndRunImportJob(
            $request,
            $factory,
            $checker,
            $session,
            FullImportRemoteSensingZipShapefileJob::class,
            $id);
    }

    public function getContributeRemoteSensingDraftError(
        Request $request,
        AuthorizationCheckerInterface $checker,
        string $id
    ) {
        try {
            if (!$checker->isGranted('ROLE_EDITOR')) {
                $this->setStatusCode(403);
                $this->respondWithErrors('Access Denied.');
            }
            $job = $this->om->find('job', $id);
            $path = $this->om->getEntityPath($job, true).'/../validationErrors.csv';
            $response = new BinaryFileResponse($path);
            // Set content disposition inline of the file
            $response->setContentDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT
            );
            $response->headers->set('Content-Type', 'text/csv');

            return $response;
        } catch (JobManagerEntityNotFoundException $e) {
            $this->setStatusCode(404);

            return $this->respondWithErrors($e->getMessage());
        }
    }

    public function getJobStatus(string $id)
    {
        try {
            $job = $this->om->find('job', $id);
        } catch (JobManagerEntityNotFoundException $e) {
            $this->setStatusCode(404);

            return $this->respondWithErrors($e->getMessage());
        }

        $converter = new JobConverter();

        return $this->respond($converter->normalize($job));
    }

    public function cancelJob(
        AuthorizationCheckerInterface $checker,
        string $id
    ) {
        try {
            if (!$checker->isGranted('ROLE_EDITOR')) {
                $this->setStatusCode(403);
                $this->respondWithErrors('Access Denied.');
            }
            $info = new JobInfo($this->om, 'job', $id);
            $info->cancel();

            return $this->respond('data');
        } catch (JobManagerEntityNotFoundException $e) {
            $this->setStatusCode(404);

            return $this->respondWithErrors($e->getMessage());
        }
    }
}
