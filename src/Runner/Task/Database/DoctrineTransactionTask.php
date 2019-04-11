<?php

namespace App\Runner\Task\Database;

use App\Runner\Task\TaskEntityManagerTrait;
use Bnza\JobManagerBundle\Event\JobEndedEvent;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;

class DoctrineTransactionTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'app:task:db:doctrine-transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultDescription(): string
    {
        return 'Envelopes job in doctrine transaction';
    }

    /**
     * {@inheritdoc}
     */
    protected function executeStep(array $arguments): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $conn->beginTransaction();
    }

    /**
     * {@inheritdoc}
     */
    public function getSteps(): iterable
    {
        return [[]];
    }

    public function configure(): void
    {
        $this->getJob()->getDispatcher()->addListener(JobEndedEvent::NAME, [$this, 'commit']);
    }

    public function commit()
    {
        $conn = $this->getEntityManager()->getConnection();
        if ($conn->isTransactionActive() && !$conn->isRollbackOnly()) {
            $conn->commit();
        }
    }

    public function rollback(): void
    {
        $conn = $this->getEntityManager()->getConnection();
        $conn->rollBack();
    }
}
