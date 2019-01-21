<?php

declare(strict_types=1);

namespace JDecool\HKParser;

/**
 * @method static HKQuantityTypeIdentifierHeight fromXml(\SimpleXMLElement $xml)
 */
class HKQuantityTypeIdentifierHeight extends Record
{
    public static function name(): string
    {
        return substr(__CLASS__, strlen(__NAMESPACE__) + 1);
    }
}
