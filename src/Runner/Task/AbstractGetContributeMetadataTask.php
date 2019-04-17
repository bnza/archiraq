<?php


namespace App\Runner\Task;


use App\Entity\ContributeEntity;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Doctrine\Common\Inflector\Inflector;

abstract class AbstractGetContributeMetadataTask extends AbstractTask
{
    /**
     * @var ContributeEntity
     */
    protected $contribute;

    abstract public function getContribute(): ContributeEntity;

    protected function generateEntity(array $values): ContributeEntity
    {
        $contribute = new ContributeEntity();
        foreach ($values as $key => $value) {
            $method = 'set'.Inflector::classify($key);
            if (method_exists($contribute, $method)) {
                $contribute->$method($value);
            }
        }

        return $contribute;
    }

    protected function parseDescription(string $description): array
    {
        $values = [];
        $pattern = '/^(?P<key>\w+):\s*(?P<value>.+)\n?$/m';
        preg_match_all($pattern, $description, $matches, PREG_SET_ORDER, 0);
        if ($matches) {
            foreach ($matches as $match) {
                $key = $match['key'];
                if (\in_array(strtolower($key), ['contributor', 'email', 'institution'])) {
                    $values[$key] = $match['value'];
                    $description = str_replace($match[0], '', $description);
                }
            }
        }
        $values['description'] = \trim($description);

        return $values;
    }
}
