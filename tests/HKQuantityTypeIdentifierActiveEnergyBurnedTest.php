<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierActiveEnergyBurned;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierActiveEnergyBurnedTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierActiveEnergyBurned', HKQuantityTypeIdentifierActiveEnergyBurned::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierActiveEnergyBurned" sourceName="Apple Watch" sourceVersion="5.0.1" device="&lt;&lt;HKDevice: 0x283368230&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1&gt;" unit="kcal" creationDate="2018-11-16 13:18:46 +0100" startDate="2018-10-28 02:30:13 +0100" endDate="2018-11-09 13:18:27 +0100" value="0.058"/>
XML;

        $instance = HKQuantityTypeIdentifierActiveEnergyBurned::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierActiveEnergyBurned::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertSame('5.0.1', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x283368230>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1>', $instance->device());
        $this->assertSame('kcal', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:18:46 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-10-28 02:30:13 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-09 13:18:27 +0100'), $instance->endDate());
        $this->assertSame('0.058', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
