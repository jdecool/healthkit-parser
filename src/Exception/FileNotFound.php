<?php

declare(strict_types=1);

namespace JDecool\HKParser\Exception;

use RuntimeException;
use Throwable;

class FileNotFound extends RuntimeException implements Exception
{
    public function __construct(string $path, int $code = 0, Throwable $previous = null)
    {
        $message = "File '$path' not found.";

        parent::__construct($message, $code, $previous);
    }
}
