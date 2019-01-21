<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use SimpleXMLElement;

class MetadataEntry
{
    private $key;
    private $value;

    public static function fromXml(SimpleXMLElement $xml): self
    {
        return new self((string) $xml['key'], (string) $xml['value']);
    }

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function key(): string
    {
        return $this->key;
    }

    public function value(): string
    {
        return $this->value;
    }
}
