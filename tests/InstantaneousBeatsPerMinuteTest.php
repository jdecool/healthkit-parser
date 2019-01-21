<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use JDecool\HKParser\InstantaneousBeatsPerMinute;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class InstantaneousBeatsPerMinuteTest extends TestCase
{
    public function testParseXml()
    {
        $xml = <<<XML
<InstantaneousBeatsPerMinute bpm="75" time="08:34:05,10"/>
XML;

        $instance = InstantaneousBeatsPerMinute::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(InstantaneousBeatsPerMinute::class, $instance);
        $this->assertSame(75, $instance->bpm());
        $this->assertSame('08:34:05,10', $instance->time());
    }

    public function testConstructor()
    {
        $instance = new InstantaneousBeatsPerMinute(75, '08:34:05,10');
        $this->assertInstanceOf(InstantaneousBeatsPerMinute::class, $instance);
        $this->assertSame(75, $instance->bpm());
        $this->assertSame('08:34:05,10', $instance->time());
    }
}
