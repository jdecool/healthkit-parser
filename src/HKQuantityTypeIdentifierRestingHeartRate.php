<?php

declare(strict_types=1);

namespace JDecool\HKParser;

/**
 * @method static HKQuantityTypeIdentifierRestingHeartRate fromXml(\SimpleXMLElement $xml)
 */
class HKQuantityTypeIdentifierRestingHeartRate extends Record
{
    public static function name(): string
    {
        return substr(__CLASS__, strlen(__NAMESPACE__) + 1);
    }
}
