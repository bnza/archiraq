<?php
namespace App\Tests\Unit\Runner\Task;

use App\Runner\Task\TaskEntityManagerTrait;

class TaskEntityManagerTraitTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage You must set EntityManager before trying to get it
     */
    public function testMethodGetEntityManagerWillThrowsExceptionWhenNoEmIsSet()
    {
        $mock = $this->getMockForTrait(TaskEntityManagerTrait::class);
        $mock->getEntityManager();
    }
}
