<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use DateTimeImmutable;
use SimpleXMLElement;

/**
 * @method static HKQuantityTypeIdentifierHeartRateVariabilitySDNN fromXml(\SimpleXMLElement $xml)
 */
class HKQuantityTypeIdentifierHeartRateVariabilitySDNN extends Record
{
    private $heartRateVariabilityMetadataList;

    public static function name(): string
    {
        return substr(__CLASS__, strlen(__NAMESPACE__) + 1);
    }


    public static function fromXml(SimpleXMLElement $data): HKModel
    {
        $instance = parent::fromXml($data);

        foreach ($data->xpath('//InstantaneousBeatsPerMinute') as $child) {
            $instance->heartRateVariabilityMetadataList[] = InstantaneousBeatsPerMinute::fromXml($child);
        }

        return $instance;
    }

    protected function __construct(string $sourceName, DateTimeImmutable $startDate, DateTimeImmutable $endDate)
    {
        parent::__construct($sourceName, $startDate, $endDate);

        $this->heartRateVariabilityMetadataList = [];
    }

    public function heartRateVariabilityMetadataList(): array
    {
        return $this->heartRateVariabilityMetadataList;
    }
}
