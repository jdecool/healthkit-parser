<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierBasalEnergyBurned;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierBasalEnergyBurnedTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierBasalEnergyBurned', HKQuantityTypeIdentifierBasalEnergyBurned::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierBasalEnergyBurned" sourceName="Apple Watch" sourceVersion="5.0.1" device="&lt;&lt;HKDevice: 0x2830f4230&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1&gt;" unit="kcal" creationDate="2018-11-16 13:18:46 +0100" startDate="2018-10-28 02:25:14 +0100" endDate="2018-11-09 13:18:27 +0100" value="18087.8"/>
XML;

        $instance = HKQuantityTypeIdentifierBasalEnergyBurned::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierBasalEnergyBurned::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertSame('5.0.1', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2830f4230>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1>', $instance->device());
        $this->assertSame('kcal', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:18:46 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-10-28 02:25:14 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-09 13:18:27 +0100'), $instance->endDate());
        $this->assertSame('18087.8', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
