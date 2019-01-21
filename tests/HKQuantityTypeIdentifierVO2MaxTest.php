<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierVO2Max;
use JDecool\HKParser\MetadataEntry;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierVO2MaxTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierVO2Max', HKQuantityTypeIdentifierVO2Max::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
 <Record type="HKQuantityTypeIdentifierVO2Max" sourceName="Apple Watch" unit="mL/min·kg" creationDate="2018-12-08 17:19:30 +0100" startDate="2018-12-08 17:19:30 +0100" endDate="2018-12-08 17:19:30 +0100" value="42.095">
  <MetadataEntry key="HKVO2MaxTestType" value="2"/>
 </Record>
XML;

        $instance = HKQuantityTypeIdentifierVO2Max::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierVO2Max::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertNull($instance->sourceVersion());
        $this->assertNull($instance->device());
        $this->assertSame('mL/min·kg', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-12-08 17:19:30 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-08 17:19:30 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-08 17:19:30 +0100'), $instance->endDate());
        $this->assertSame('42.095', $instance->value());
        $this->assertCount(1, $instance->metadata());
        $this->assertEquals(new MetadataEntry('HKVO2MaxTestType', '2'), $instance->metadata()[0]);
    }
}
