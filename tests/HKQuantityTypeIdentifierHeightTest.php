<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierHeight;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierHeightTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierHeight', HKQuantityTypeIdentifierHeight::name());
    }
    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierHeight" sourceName="Foo" sourceVersion="12.1" unit="cm" creationDate="2018-11-16 13:24:18 +0100" startDate="2018-11-16 13:24:18 +0100" endDate="2018-11-16 13:24:18 +0100" value="183"/>
XML;

        $instance = HKQuantityTypeIdentifierHeight::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierHeight::class, $instance);
        $this->assertSame('Foo', $instance->sourceName());
        $this->assertSame('12.1', $instance->sourceVersion());
        $this->assertNull($instance->device());
        $this->assertSame('cm', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $instance->endDate());
        $this->assertSame('183', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
