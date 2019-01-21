<?php

declare(strict_types=1);

namespace JDecool\HKParser;

/**
 * @method static HKQuantityTypeIdentifierHeartRate fromXml(\SimpleXMLElement $xml)
 */
class HKQuantityTypeIdentifierHeartRate extends Record
{
    public static function name(): string
    {
        return substr(__CLASS__, strlen(__NAMESPACE__) + 1);
    }
}
