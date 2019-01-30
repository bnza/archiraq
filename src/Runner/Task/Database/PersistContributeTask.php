<?php

namespace App\Runner\Task\Database;

use App\Entity\ContributeEntity;
use App\Runner\Task\TaskEntityManagerTrait;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Doctrine\Common\Inflector\Inflector;

class PersistContributeTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    /**
     * @var ContributeEntity
     */
    protected $contribute;

    public function getName(): string
    {
        return 'app:task:db:persist-contribute';
    }

    public function getDefaultDescription(): string
    {
        return 'Persisting "contribute" entity to DB';
    }

    protected function executeStep(array $arguments): void
    {
        $this->getEntityManager()->persist($this->getContribute());
    }

    public function getSteps(): iterable
    {
        return [[]];
    }

    /**
     * @return ContributeEntity
     */
    public function getContribute(): ContributeEntity
    {
        return $this->contribute;
    }

    /**
     * @param mixed $contribute
     */
    public function setContribute($contribute): void
    {
        if (\is_array($contribute)) {
            $contribute = $this->hydrateContributeEntityFromArray($contribute);
        } elseif (\is_string($contribute)) {
            if (strlen($contribute) && ctype_xdigit($contribute)) {
                $key = 'sha1';
                $value = $contribute;
                $contribute = $this->getEntityManager()->getRepository(ContributeEntity::class)->findBy(['sha1' => $contribute]);
            } else {
                throw new \InvalidArgumentException(sprintf('Invalid sha1 hash "%s"', $contribute));
            }
        } else if (\is_int($contribute)) {
            $key = 'id';
            $value = $contribute;
            $contribute = $this->getEntityManager()->getRepository(ContributeEntity::class)->find($contribute);
        } else if (!$contribute instanceof ContributeEntity) {
            $message = sprintf('Invalid argument type: %s', gettype($contribute));
            if (\is_object($contribute)) {
                $message .= " [".\get_class($contribute)."]";
            }
            throw new \InvalidArgumentException($message);
        }
        if (!$contribute) {
            throw new \RuntimeException("No contribute found with $key = $value");
        }
        $this->contribute = $contribute;
    }

    protected function hydrateContributeEntityFromArray(array $data): ContributeEntity
    {
        $contribute = new ContributeEntity();
        foreach ($data as $key => $value) {
            $method = 'set'.Inflector::classify($key);
            if (\method_exists($contribute, $method)) {
                $contribute->$method($value);
            } else {
                throw new \InvalidArgumentException("Property \"$key\" does not exist in ContributeEntity");
            }
        }
        return $contribute;
    }

    public function terminate(): void
    {
        $this->getEntityManager()->flush();
    }
}
