<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use SimpleXMLElement;

class InstantaneousBeatsPerMinute
{
    private $bpm;
    private $time;

    public static function fromXml(SimpleXMLElement $xml): self
    {
        return new self((int) $xml['bpm'], (string) $xml['time']);
    }

    public function __construct(int $bpm, string $time)
    {
        $this->bpm = $bpm;
        $this->time = $time;
    }

    public function bpm(): int
    {
        return $this->bpm;
    }

    public function time()
    {
        return $this->time;
    }
}
