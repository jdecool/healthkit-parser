<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierAppleExerciseTime;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierAppleExerciseTimeTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierAppleExerciseTime', HKQuantityTypeIdentifierAppleExerciseTime::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierAppleExerciseTime" sourceName="Apple Watch" sourceVersion="5.1.2" device="&lt;&lt;HKDevice: 0x2830d10e0&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2&gt;" unit="min" creationDate="2019-01-17 18:46:32 +0100" startDate="2019-01-17 18:45:27 +0100" endDate="2019-01-17 18:46:27 +0100" value="1"/>
XML;

        $instance = HKQuantityTypeIdentifierAppleExerciseTime::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierAppleExerciseTime::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertSame('5.1.2', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2830d10e0>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2>', $instance->device());
        $this->assertSame('min', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2019-01-17 18:46:32 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-17 18:45:27 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-17 18:46:27 +0100'), $instance->endDate());
        $this->assertSame('1', $instance->value());
        $this->assertCount(0, $instance->metadata());
    }
}
