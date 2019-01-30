<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 01/02/19
 * Time: 11.45
 */

namespace App\Runner\Task\Spreadsheet;

use App\Entity\ContributeEntity;
use Bnza\JobManagerBundle\Runner\Task\AbstractTask;
use Doctrine\Common\Inflector\Inflector;

class GetContributeFromSpreadsheetMetadataTask extends AbstractTask
{
    use SpreadsheetInteractionTrait;

    /**
     * @var ContributeEntity
     */
    protected $contribute;

    public function getName(): string
    {
        return 'app:task:spreadsheet:get-contribute-metadata';
    }

    public function getDefaultDescription(): string
    {
        return 'Extracting contribute data from metadata';
    }

    protected function executeStep(array $arguments): void
    {
        $this->extractFromSpreadsheet();
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
        if (!$this->contribute) {
            $this->contribute = $this->extractFromSpreadsheet();
        }
        return $this->contribute;
    }

    protected function extractFromSpreadsheet(): ContributeEntity
    {
        $props = $this->getSpreadsheetProperties();

        $values = [
            'sha1' => $this->getJob()->getId(),
            'title' => $props->getTitle() ?: null,
            'subject' => $props->getSubject() ?: null,
            'keywords' => $props->getKeywords()
        ];

        $descriptionValues = $this->parseDescription($props->getDescription());

        $values = \array_merge($values, $descriptionValues);

        return $this->generateEntity($values);
    }

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

