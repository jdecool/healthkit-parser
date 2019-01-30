<?php

declare(strict_types=1);

namespace JDecool\HKParser\Exception;

use Throwable;

class InvalidXml extends RuntimeException
{
    public static function parsingError(Throwable $previous = null): self
    {
        return new self('An error occured on XML parsing', 0, $previous);
    }

    public static function misggingRecordType(Throwable $previous = null): self
    {
        return new self('Missing type on record type', 0, $previous);
    }
}
