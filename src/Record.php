<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use DateTimeImmutable;
use SimpleXMLElement;

abstract class Record implements HKModel
{
    protected $sourceName;
    protected $sourceVersion;
    protected $device;
    protected $unit;
    protected $creationDate;
    protected $startDate;
    protected $endDate;
    protected $value;

    /** @var MetadataEntry[] */
    protected $metadata;

    /**
     * @return Record
     */
    public static function fromXml(SimpleXMLElement $data): HKModel
    {
        $instance = new static((string) $data['sourceName'], new DateTimeImmutable((string) $data['startDate']), new DateTimeImmutable((string) $data['endDate']));
        $instance->sourceVersion = ('' !== (string) ($data['sourceVersion'])) ? ((string) ($data['sourceVersion'])) : null;
        $instance->device = ('' !== (string) $data['device']) ? ((string) $data['device']) : null;
        $instance->unit = (string) ($data['unit'] ?? '');
        $instance->creationDate = ((string) $data['creationDate']) ? new DateTimeImmutable((string) $data['creationDate']) : null;
        $instance->value = (string) $data['value'];

        foreach ($data->children() as $child) {
            switch ($child->getName()) {
                case 'MetadataEntry':
                    $instance->metadata[] = MetadataEntry::fromXml($child);
                    break;
            }
        }

        return $instance;
    }

    protected function __construct(string $sourceName, DateTimeImmutable $startDate, DateTimeImmutable $endDate)
    {
        $this->sourceName = $sourceName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->metadata = [];
    }

    public function sourceName(): string
    {
        return $this->sourceName;
    }

    public function sourceVersion(): ?string
    {
        return $this->sourceVersion;
    }

    public function device(): ?string
    {
        return $this->device;
    }

    public function unit(): string
    {
        return $this->unit;
    }

    public function creationDate(): ?DateTimeImmutable
    {
        return $this->creationDate;
    }

    public function startDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function endDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return MetadataEntry[]
     */
    public function metadata(): array
    {
        return $this->metadata;
    }
}
