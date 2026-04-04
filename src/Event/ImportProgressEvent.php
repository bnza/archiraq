<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\Event;

class ImportProgressEvent extends Event
{
    public const REFRESH_STARTED = 'import.refresh_started';
    public const REFRESH_FINISHED = 'import.refresh_finished';

    private $message;

    public function __construct(string $message = '')
    {
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
