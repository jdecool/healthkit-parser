<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierDistanceWalkingRunning;
use JDecool\HKParser\MetadataEntry;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierDistanceWalkingRunningTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierDistanceWalkingRunning', HKQuantityTypeIdentifierDistanceWalkingRunning::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierDistanceWalkingRunning" sourceName="Foo" sourceVersion="5.1.2" device="&lt;&lt;HKDevice: 0x2833a7250&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2&gt;" unit="km" creationDate="2019-01-11 18:10:12 +0100" startDate="2019-01-11 18:09:42 +0100" endDate="2019-01-11 18:10:10 +0100" value="0.0540796"/>
XML;

        $instance = HKQuantityTypeIdentifierDistanceWalkingRunning::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierDistanceWalkingRunning::class, $instance);
        $this->assertSame('Foo', $instance->sourceName());
        $this->assertSame('5.1.2', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2833a7250>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2>', $instance->device());
        $this->assertSame('km', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 18:10:12 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 18:09:42 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 18:10:10 +0100'), $instance->endDate());
        $this->assertSame('0.0540796', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }

    public function testParseTagWithMetadata()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierDistanceWalkingRunning" sourceName="Bar" sourceVersion="15009" unit="km" creationDate="2019-01-11 18:11:33 +0100" startDate="2019-01-11 12:34:03 +0100" endDate="2019-01-11 13:13:54 +0100" value="6.8552">
  <MetadataEntry key="HKIndoorWorkout" value="0"/>
  <MetadataEntry key="HKExternalUUID" value="strava://activities/2071320016"/>
</Record>
XML;

        $instance = HKQuantityTypeIdentifierDistanceWalkingRunning::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierDistanceWalkingRunning::class, $instance);
        $this->assertSame('Bar', $instance->sourceName());
        $this->assertSame('15009', $instance->sourceVersion());
        $this->assertNull($instance->device());
        $this->assertSame('km', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 18:11:33 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 12:34:03 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 13:13:54 +0100'), $instance->endDate());
        $this->assertSame('6.8552', $instance->value());

        $this->assertCount(2, $instance->metadata());
        $this->assertEquals(new MetadataEntry('HKIndoorWorkout', '0'), $instance->metadata()[0]);
        $this->assertEquals(new MetadataEntry('HKExternalUUID', 'strava://activities/2071320016'), $instance->metadata()[1]);
    }
}
