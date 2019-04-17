<?php

namespace App\Runner\Task\Database\Raw;

use App\Runner\Task\TaskEntityManagerTrait;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Doctrine\DBAL\Statement;

abstract class AbstractInsertIntoTmpDraftTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    /**
     * @var Statement
     */
    protected $stmt;

    abstract protected function getIdGenerator(): \Generator;

    abstract protected function prepareInsertQueryStatement();

    public function getSteps(): iterable
    {
        foreach ($this->getIdGenerator() as $id) {
            yield [$id];
        }
    }

    protected function executeStep(array $arguments): void
    {
        $this->getInsertPreparedStatement()->execute(['id' => $arguments[0]]);
    }

    protected function getInsertPreparedStatement()
    {
        if (!$this->stmt) {
            $this->prepareInsertQueryStatement();
        }

        return $this->stmt;
    }
}
