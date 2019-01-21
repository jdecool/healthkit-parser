<?php

declare(strict_types=1);

namespace JDecool\HKParser;

/**
 * @method static HKQuantityTypeIdentifierDistanceWalkingRunning fromXml(\SimpleXMLElement $xml)
 */
class HKQuantityTypeIdentifierDistanceWalkingRunning extends Record
{
    public static function name(): string
    {
        return substr(__CLASS__, strlen(__NAMESPACE__) + 1);
    }
}
