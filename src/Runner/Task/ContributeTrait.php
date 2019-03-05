<?php

namespace App\Runner\Task;

use App\Entity\ContributeEntity;

trait ContributeTrait
{

    /**
     * @var ContributeEntity
     */
    protected $contribute;

    /**
     * @return ContributeEntity
     */
    public function getContribute(): ContributeEntity
    {
        return $this->contribute;
    }

    /**
     * @param ContributeEntity $contribute
     */
    public function setContribute(ContributeEntity $contribute): void
    {
        $this->contribute = $contribute;
    }
}
