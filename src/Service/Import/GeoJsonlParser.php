<?php

namespace App\Service\Import;

class GeoJsonlParser
{
    private $typeDetector;

    public function __construct(GeoJsonlTypeDetector $typeDetector)
    {
        $this->typeDetector = $typeDetector;
    }

    /**
     * @param string $filePath
     * @param string|null $forcedType
     * @return \Generator
     */
    public function parse(string $filePath, ?string $forcedType = null): \Generator
    {
        if (!file_exists($filePath)) {
            throw new \RuntimeException("File not found: $filePath");
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \RuntimeException("Could not open file: $filePath");
        }

        try {
            $lineNumber = 0;
            $type = $forcedType;
            $dtoClass = null;

            while (($line = fgets($handle)) !== false) {
                $lineNumber++;
                $line = trim($line);
                if (empty($line)) {
                    continue;
                }

                $data = json_decode($line, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new \RuntimeException("Invalid JSON at line $lineNumber: " . json_last_error_msg());
                }

                if ($type === null) {
                    $type = $this->typeDetector->detect($data);
                }

                if ($dtoClass === null) {
                    $dtoClass = $this->typeDetector->getDtoClass($type);
                }

                yield new $dtoClass($data['properties'] ?? [], $data['geometry'] ?? []);
            }
        } finally {
            fclose($handle);
        }
    }
}
