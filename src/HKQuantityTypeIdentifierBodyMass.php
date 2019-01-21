<?php

declare(strict_types=1);

namespace JDecool\HKParser;

/**
 * @method static HKQuantityTypeIdentifierBodyMass fromXml(\SimpleXMLElement $xml)
 */
class HKQuantityTypeIdentifierBodyMass extends Record
{
    public static function name(): string
    {
        return substr(__CLASS__, strlen(__NAMESPACE__) + 1);
    }
}
