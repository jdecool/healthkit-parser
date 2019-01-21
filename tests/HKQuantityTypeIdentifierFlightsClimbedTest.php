<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierFlightsClimbed;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierFlightsClimbedTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierFlightsClimbed', HKQuantityTypeIdentifierFlightsClimbed::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierFlightsClimbed" sourceName="iPhone" sourceVersion="12.0" device="&lt;&lt;HKDevice: 0x2830f01e0&gt;, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone10,4, software:12.0&gt;" unit="count" creationDate="2018-09-30 20:19:34 +0100" startDate="2018-09-30 19:56:31 +0100" endDate="2018-09-30 19:56:34 +0100" value="1"/>
XML;

        $instance = HKQuantityTypeIdentifierFlightsClimbed::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierFlightsClimbed::class, $instance);
        $this->assertSame('iPhone', $instance->sourceName());
        $this->assertSame('12.0', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2830f01e0>, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone10,4, software:12.0>', $instance->device());
        $this->assertSame('count', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-09-30 20:19:34 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-09-30 19:56:31 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-09-30 19:56:34 +0100'), $instance->endDate());
        $this->assertSame('1', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
