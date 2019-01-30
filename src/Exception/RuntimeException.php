<?php

declare(strict_types=1);

namespace JDecool\HKParser\Exception;

use Throwable;

class RuntimeException extends \RuntimeException implements Exception
{
    public static function noParserImplemented(string $tag, Throwable $previous = null): self
    {
        return new self("No parser is implemented for '$tag' tag", 0, $previous);
    }
}
