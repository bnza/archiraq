<?php

namespace App\Tests\Functional;


use App\Tests\Unit\MockUtilsTrait;

trait JobUtilsTrait
{
    use MockUtilsTrait;

    /**
     * @var iterable[]
     */
    protected $steps = [];

    /**
     * Return the
     * @param $className
     * @return iterable
     */
    protected function getJobStepsFromClass($className): iterable
    {
        $job =  $this->getMockWithMockedMethods($className, []);

        $steps = $job->getSteps();

        return $this->replaceObjectInstanceWithPlaceholder($steps, $job, $className);
    }

    /**
     * Return a subset of job's steps
     * @param string $className The job classname
     * @param int $limit The upper limit step's index
     * @return iterable The job's steps subset
     */
    protected function getJobSteps(string $className, $object = null, $limit = -1): iterable
    {
        if (!isset($this->steps[$className])) {
            $this->steps[$className] = $this->getJobStepsFromClass($className);
        }

        $steps = $this->replacePlaceholderWithObjectInstance($this->steps[$className], $object, $className);

        if ($limit === -1) {
            return $steps;
        } else {
            if (\is_array($steps)) {
                return \array_slice($steps, 0, $limit + 1);
            } else {
                $generator = function () use ($steps, $limit) {
                    foreach ($steps as $i => $step) {
                        if ($limit > $i) {
                            break;
                        }
                        yield $step;
                    }
                };
                $this->steps[$className] = $generator();
                return $generator();
            }
        }
    }

    /**
     * Replaces the given object instance with a class name string placeholder(e.g. 'Fully/Qualified/Namespaced/Class')
     * @param array $data The haystack
     * @param $object The object instance to replace
     * @param string $placeholder The fully qualified class name
     * @return array
     */
    protected function replaceObjectInstanceWithPlaceholder(array $data, $object, string $placeholder): array
    {
        foreach ($data as $key => $datum) {
            if (\is_array($datum)) {
                $data[$key] = $this->replaceObjectInstanceWithPlaceholder($datum, $object, $placeholder);
            } else {
                if (\is_object($datum) && $datum === $object) {
                    $data[$key] = "**$placeholder**";
                }
            }
        }
        return $data;
    }

    /**
     * Replaces a class name string placeholder(e.g. 'Fully/Qualified/Namespaced/Class') with the given object instance
     * @param array $data The haystack
     * @param $object The object instance to replace
     * @param string $placeholder The fully qualified class name
     * @return array
     */
    protected function replacePlaceholderWithObjectInstance(array $data, $object, string $placeholder): array
    {
        $pattern = '/^\*\*(?P<class>[\w+\\\\?]+)\*\*$/';
        foreach ($data as $key => $datum) {
            if (\is_array($datum)) {
                $data[$key] = $this->replacePlaceholderWithObjectInstance($datum, $object, $placeholder);
            } else {
                if (\is_string($datum)) {
                    if (preg_match($pattern, $datum, $matches)) {
                        if (\class_exists($matches['class']) && $object instanceof $matches['class']) {
                            $data[$key] = $object;
                        }
                    }
                }
            }
        }
        return $data;
    }
}
