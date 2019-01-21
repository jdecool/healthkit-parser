<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierRestingHeartRate;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierRestingHeartRateTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierRestingHeartRate', HKQuantityTypeIdentifierRestingHeartRate::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierRestingHeartRate" sourceName="Apple Watch" sourceVersion="5.1.1" unit="count/min" creationDate="2018-11-30 21:11:57 +0100" startDate="2018-11-30 06:13:30 +0100" endDate="2018-11-30 21:06:16 +0100" value="49"/>
XML;

        $instance = HKQuantityTypeIdentifierRestingHeartRate::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierRestingHeartRate::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertSame('5.1.1', $instance->sourceVersion());
        $this->assertNull($instance->device());
        $this->assertSame('count/min', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-30 21:11:57 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-30 06:13:30 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-30 21:06:16 +0100'), $instance->endDate());
        $this->assertSame('49', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
