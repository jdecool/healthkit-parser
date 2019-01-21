<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierStepCount;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierStepCountTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierStepCount', HKQuantityTypeIdentifierStepCount::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierStepCount" sourceName="iPhone" sourceVersion="9.3.2" device="&lt;&lt;HKDevice: 0x28301c1e0&gt;, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone8,4, software:9.3.2&gt;" unit="count" creationDate="2016-07-11 23:03:23 +0100" startDate="2016-07-11 21:58:42 +0100" endDate="2016-07-11 21:59:05 +0100" value="14"/>
XML;

        $instance = HKQuantityTypeIdentifierStepCount::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierStepCount::class, $instance);
        $this->assertSame('iPhone', $instance->sourceName());
        $this->assertSame('9.3.2', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x28301c1e0>, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone8,4, software:9.3.2>', $instance->device());
        $this->assertSame('count', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2016-07-11 23:03:23 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2016-07-11 21:58:42 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2016-07-11 21:59:05 +0100'), $instance->endDate());
        $this->assertSame('14', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
