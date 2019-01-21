<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use SimpleXMLElement;

class HKDevice
{
    private $device; // string(108) "<<HKDevice: 0x2833682d0>, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone8,4, software:9.3.2>"

    public static function fromString(string $xml): self
    {
        dump($xml);die;


        return self::fromXml(new SimpleXMLElement($xml));
    }

    public static function fromXml(SimpleXMLElement $data): self
    {
        $instance = new self();

        dump($data);die;

        return $instance;
    }
}
