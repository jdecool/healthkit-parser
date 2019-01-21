<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierHeartRate;
use JDecool\HKParser\MetadataEntry;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierHeartRateTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierHeartRate', HKQuantityTypeIdentifierHeartRate::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierHeartRate" sourceName="Apple Watch" sourceVersion="5.0.1" device="&lt;&lt;HKDevice: 0x2833968a0&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1&gt;" unit="count/min" creationDate="2018-11-16 13:36:42 +0100" startDate="2018-11-16 13:28:45 +0100" endDate="2018-11-16 13:28:45 +0100" value="90">
  <MetadataEntry key="HKMetadataKeyHeartRateMotionContext" value="0"/>
</Record>
XML;

        $instance = HKQuantityTypeIdentifierHeartRate::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierHeartRate::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertSame('5.0.1', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2833968a0>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1>', $instance->device());
        $this->assertSame('count/min', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:36:42 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:28:45 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:28:45 +0100'), $instance->endDate());
        $this->assertSame('90', $instance->value());
        $this->assertCount(1, $instance->metadata());
        $this->assertEquals(new MetadataEntry('HKMetadataKeyHeartRateMotionContext', '0'), $instance->metadata()[0]);
    }
}
