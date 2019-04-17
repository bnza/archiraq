<?php


namespace App\Runner\Task;


use App\Entity\ContributeEntity;

class GetContributeMetadataFromTextFileTask extends AbstractGetContributeMetadataTask
{
    /**
     * @var string
     */
    private $textMetadataFilePath;

    public function getName(): string
    {
        return 'app:task:text:get-contribute-metadata';
    }

    public function getDefaultDescription(): string
    {
        return 'Extracting contribute metadata data from text file';
    }

    protected function executeStep(array $arguments): void
    {
        $this->extractFromTextFile();
    }

    public function getSteps(): iterable
    {
        return [[]];
    }

    public function getContribute(): ContributeEntity
    {
        if (!$this->contribute) {
            $this->contribute = $this->extractFromTextFile();
        }

        return $this->contribute;
    }

    /**
     * @return string
     */
    public function getTextMetadataFilePath(): string
    {
        return $this->textMetadataFilePath;
    }

    /**
     * @param string $textMetadataFilePath
     */
    public function setTextMetadataFilePath(string $textMetadataFilePath): void
    {
        $this->textMetadataFilePath = $textMetadataFilePath;
    }

    protected function extractFromTextFile(): ContributeEntity
    {
        $description = \file_get_contents($this->getTextMetadataFilePath());

        $values = [
            'sha1' => $this->getJob()->getId()
        ];

        $descriptionValues = $this->parseDescription($description);

        $values = \array_merge($values, $descriptionValues);

        return $this->generateEntity($values);
    }

}
