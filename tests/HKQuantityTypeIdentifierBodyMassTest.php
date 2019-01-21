<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierBodyMass;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierBodyMassTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierBodyMass', HKQuantityTypeIdentifierBodyMass::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierBodyMass" sourceName="iPhone" sourceVersion="12.1" unit="kg" creationDate="2018-11-16 13:24:18 +0100" startDate="2018-11-16 13:24:18 +0100" endDate="2018-11-16 13:24:18 +0100" value="83"/>
XML;

        $instance = HKQuantityTypeIdentifierBodyMass::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierBodyMass::class, $instance);
        $this->assertSame('iPhone', $instance->sourceName());
        $this->assertSame('12.1', $instance->sourceVersion());
        $this->assertNull($instance->device());
        $this->assertSame('kg', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $instance->endDate());
        $this->assertSame('83', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
