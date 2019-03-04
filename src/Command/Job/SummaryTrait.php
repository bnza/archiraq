<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 04/02/19
 * Time: 15.23.
 */

namespace App\Command\Job;

use Bnza\JobManagerBundle\Runner\Job\JobInterface;
use Bnza\JobManagerBundle\Summary\Summary;

trait SummaryTrait
{
    /**
     * @var Summary
     */
    private $summary;

    abstract public function getJob(): JobInterface;

    public function setSummary(Summary $summary)
    {
        $this->summary = $summary;
    }
}
