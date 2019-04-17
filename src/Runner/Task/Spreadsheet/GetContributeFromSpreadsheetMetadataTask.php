<?php

namespace App\Runner\Task\Spreadsheet;

use App\Entity\ContributeEntity;
use App\Runner\Task\AbstractGetContributeMetadataTask;

class GetContributeFromSpreadsheetMetadataTask extends AbstractGetContributeMetadataTask
{
    use SpreadsheetInteractionTrait;

    public function getName(): string
    {
        return 'app:task:spreadsheet:get-contribute-metadata';
    }

    public function getDefaultDescription(): string
    {
        return 'Extracting contribute data from spreadsheet metadata';
    }

    protected function executeStep(array $arguments): void
    {
        $this->extractFromSpreadsheet();
    }

    public function getSteps(): iterable
    {
        return [[]];
    }

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
            'keywords' => $props->getKeywords(),
        ];

        $descriptionValues = $this->parseDescription($props->getDescription());

        $values = \array_merge($values, $descriptionValues);

        return $this->generateEntity($values);
    }
}
