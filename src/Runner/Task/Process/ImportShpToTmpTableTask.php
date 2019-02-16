<?php

namespace App\Runner\Task\Process;

use App\Runner\Task\TaskEntityManagerTrait;
use Bnza\JobManagerBundle\Event\JobEndedEvent;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ImportShpToTmpTableTask extends AbstractTask
{
    use TaskEntityManagerTrait;

    private $source;

    private $dumpFile;

    public function getName(): string
    {
        return 'app:task:process:shp2pgsql-tmp-table';
    }

    public function getDefaultDescription(): string
    {
        return 'Importing shapefile into db using shp2pgsql command';
    }

    protected function getDumpFile()
    {
        // TODO Verify shapefile projection
        if (!$this->dumpFile) {
            $shp2pgsqlCommand = $this->getFullPathCommand('shp2pgsql');
            $shp2pgsqlArguments = sprintf(' -e -s %d %s %s', 4326, $this->getSource(), $this->getTableName());
            $source = $this->getSource();
            $this->dumpFile = \dirname($source).DIRECTORY_SEPARATOR.'shp-dump-'.\basename($source).'.sql';
            $command = "$shp2pgsqlCommand $shp2pgsqlArguments > $this->dumpFile";
            $process = Process::fromShellCommandline($command);
            try {
                $process->mustRun();
            } catch (ProcessFailedException $exception) {
                echo $exception->getMessage();
            }
        }

        return $this->dumpFile;
    }

    protected function getDDL()
    {
        $ddlPattern = '/(?s)^CREATE TABLE.+\);\nALTER TABLE.+\);\nSELECT AddGeometryColumn.+\);/mU';
        \preg_match($ddlPattern, \file_get_contents($this->getDumpFile()), $matches);
        if (!$matches) {
            throw new \InvalidArgumentException('Invalid DDL in shapefile SQL dump');
        }
        $ddl = 'SET search_path = "public";'."\n".$matches[0];

        return $ddl;
    }

    protected function getDMLs(): \Generator
    {
        $dmlPattern = '/^INSERT INTO\s+'.$this->getTableName().'.*;\n/m';
        \preg_match_all($dmlPattern, \file_get_contents($this->getDumpFile()), $matches);
        $generator = function () use ($matches) {
            foreach ($matches as $match) {
                yield $match;
            }
        };

        return $generator();
    }

    public function getSteps(): iterable
    {
        return $this->getDMLs();
    }

    public function configure(): void
    {
        $this->getJob()->getDispatcher()->addListener(JobEndedEvent::NAME, [$this, 'dropTemporaryTable']);
        $ddl = $this->getDDL();
        $this->getEntityManager()->getConnection()->exec($ddl);
    }

    public function executeStep(array $arguments): void
    {
        $this->getEntityManager()->getConnection()->exec(...$arguments);
    }

    /**
     * @param mixed $source
     */
    public function setSource($source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getBinDir(): string
    {
        return \getenv('PGBINDIR');
    }

    /**
     * @return mixed
     */
    public function getSource()
    {
        if (!$this->source) {
            throw new \LogicException('You must set source file before trying to get it');
        }

        return $this->source;
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }

    public function getTableName(): string
    {
        return sprintf('"%s"."shp2pgsql%s"', $this->getSchema(), $this->getJob()->getId());
    }

    public function getFullPathCommand(string $command): string
    {
        if ($fullPathCommand = realpath($this->getBinDir().DIRECTORY_SEPARATOR.$command)) {
            return $fullPathCommand;
        }

        return $command;
    }

    public function dropTemporaryTable()
    {
        $ddl = "DROP TABLE {$this->getTableName()};";
        $this->getEntityManager()->getConnection()->exec($ddl);
    }
}
