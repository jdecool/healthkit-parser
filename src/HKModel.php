<?php

namespace JDecool\HKParser;

use SimpleXMLElement;

interface HKModel
{
    public static function name(): string;
    public static function fromXml(SimpleXMLElement $xml): self;
}
