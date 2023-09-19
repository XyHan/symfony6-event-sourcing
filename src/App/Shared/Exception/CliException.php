<?php

declare(strict_types=1);

namespace App\Shared\Exception;

use Exception;
use Throwable;

class CliException extends Exception
{
    private function __construct(string $message, Throwable $previous)
    {
        parent::__construct($message, 001, $previous);
    }

    public static function FromCommandExecution(Throwable $previous): self
    {
        return new self(sprintf('An error has been thrown during command execution: %s', $previous->getMessage()), $previous);
    }
}
