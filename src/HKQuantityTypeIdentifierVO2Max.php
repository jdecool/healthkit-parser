<?php

declare(strict_types=1);

namespace JDecool\HKParser;

/**
 * @method static HKQuantityTypeIdentifierVO2Max fromXml(\SimpleXMLElement $xml)
 */
class HKQuantityTypeIdentifierVO2Max extends Record
{
    public static function name(): string
    {
        return substr(__CLASS__, strlen(__NAMESPACE__) + 1);
    }
}
