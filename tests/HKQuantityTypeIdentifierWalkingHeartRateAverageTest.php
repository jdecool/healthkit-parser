<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierWalkingHeartRateAverage;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierWalkingHeartRateAverageTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierWalkingHeartRateAverage', HKQuantityTypeIdentifierWalkingHeartRateAverage::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierWalkingHeartRateAverage" sourceName="Apple Watch" sourceVersion="5.1.2" unit="count/min" creationDate="2018-12-22 00:33:44 +0100" startDate="2018-12-21 08:03:56 +0100" endDate="2018-12-21 18:55:21 +0100" value="107.5"/>
XML;

        $instance = HKQuantityTypeIdentifierWalkingHeartRateAverage::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierWalkingHeartRateAverage::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertSame('5.1.2', $instance->sourceVersion());
        $this->assertNull($instance->device());
        $this->assertSame('count/min', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-12-22 00:33:44 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-21 08:03:56 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-21 18:55:21 +0100'), $instance->endDate());
        $this->assertSame('107.5', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
