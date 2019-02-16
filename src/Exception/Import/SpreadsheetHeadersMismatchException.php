<?php

namespace App\Exception\Import;

use Throwable;

class SpreadsheetHeadersMismatchException extends \InvalidArgumentException
{
    protected $expected;

    protected $actual;

    public function __construct(array $expected, array $actual, $class, string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->expected = $expected;

        $this->actual = $actual;

        $message = "Spreadsheet headers does not match the expected ones in class \"$class\"";

        parent::__construct($message, $code, $previous);
    }

    public function getActual(): array
    {
        return $this->actual;
    }

    public function getExpected(): array
    {
        return $this->expected;
    }
}
