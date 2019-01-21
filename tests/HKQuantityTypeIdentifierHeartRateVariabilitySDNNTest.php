<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\HKQuantityTypeIdentifierHeartRateVariabilitySDNN;
use JDecool\HKParser\InstantaneousBeatsPerMinute;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HKQuantityTypeIdentifierHeartRateVariabilitySDNNTest extends TestCase
{
    public function testName()
    {
        $this->assertSame('HKQuantityTypeIdentifierHeartRateVariabilitySDNN', HKQuantityTypeIdentifierHeartRateVariabilitySDNN::name());
    }

    public function testParseTag()
    {
        $xml = <<<XML
<Record type="HKQuantityTypeIdentifierHeartRateVariabilitySDNN" sourceName="Apple Watch" sourceVersion="5.1.1" device="&lt;&lt;HKDevice: 0x283336ee0&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.1&gt;" unit="ms" creationDate="2018-11-19 08:34:44 +0100" startDate="2018-11-19 08:33:39 +0100" endDate="2018-11-19 08:34:44 +0100" value="25.5526">
  <HeartRateVariabilityMetadataList>
   <InstantaneousBeatsPerMinute bpm="78" time="08:33:44,67"/>
   <InstantaneousBeatsPerMinute bpm="71" time="08:33:48,87"/>
   <InstantaneousBeatsPerMinute bpm="80" time="08:33:55,04"/>
   <InstantaneousBeatsPerMinute bpm="80" time="08:33:55,79"/>
   <InstantaneousBeatsPerMinute bpm="79" time="08:33:56,55"/>
   <InstantaneousBeatsPerMinute bpm="76" time="08:33:57,34"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:33:58,14"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:33:58,94"/>
   <InstantaneousBeatsPerMinute bpm="77" time="08:33:59,72"/>
   <InstantaneousBeatsPerMinute bpm="78" time="08:34:00,48"/>
   <InstantaneousBeatsPerMinute bpm="79" time="08:34:03,52"/>
   <InstantaneousBeatsPerMinute bpm="77" time="08:34:04,30"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:34:05,10"/>
   <InstantaneousBeatsPerMinute bpm="74" time="08:34:05,92"/>
   <InstantaneousBeatsPerMinute bpm="74" time="08:34:06,73"/>
   <InstantaneousBeatsPerMinute bpm="73" time="08:34:07,55"/>
   <InstantaneousBeatsPerMinute bpm="73" time="08:34:08,38"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:34:09,18"/>
   <InstantaneousBeatsPerMinute bpm="78" time="08:34:09,95"/>
   <InstantaneousBeatsPerMinute bpm="80" time="08:34:13,03"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:34:13,83"/>
   <InstantaneousBeatsPerMinute bpm="79" time="08:34:16,95"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:34:17,75"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:34:18,55"/>
   <InstantaneousBeatsPerMinute bpm="73" time="08:34:19,36"/>
   <InstantaneousBeatsPerMinute bpm="75" time="08:34:34,85"/>
   <InstantaneousBeatsPerMinute bpm="77" time="08:34:35,63"/>
  </HeartRateVariabilityMetadataList>
</Record>
XML;

        $instance = HKQuantityTypeIdentifierHeartRateVariabilitySDNN::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(HKQuantityTypeIdentifierHeartRateVariabilitySDNN::class, $instance);
        $this->assertSame('Apple Watch', $instance->sourceName());
        $this->assertSame('5.1.1', $instance->sourceVersion());
        $this->assertSame('<<HKDevice: 0x283336ee0>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.1>', $instance->device());
        $this->assertSame('ms', $instance->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-19 08:34:44 +0100'), $instance->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-19 08:33:39 +0100'), $instance->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-19 08:34:44 +0100'), $instance->endDate());
        $this->assertSame('25.5526', $instance->value());
        $this->assertCount(0, $instance->metadata());

        $this->assertCount(27, $instance->heartRateVariabilityMetadataList());
        $this->assertEquals(new InstantaneousBeatsPerMinute(78, '08:33:44,67'), $instance->heartRateVariabilityMetadataList()[0]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(71, '08:33:48,87'), $instance->heartRateVariabilityMetadataList()[1]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(80, '08:33:55,04'), $instance->heartRateVariabilityMetadataList()[2]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(80, '08:33:55,79'), $instance->heartRateVariabilityMetadataList()[3]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(79, '08:33:56,55'), $instance->heartRateVariabilityMetadataList()[4]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(76, '08:33:57,34'), $instance->heartRateVariabilityMetadataList()[5]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:33:58,14'), $instance->heartRateVariabilityMetadataList()[6]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:33:58,94'), $instance->heartRateVariabilityMetadataList()[7]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(77, '08:33:59,72'), $instance->heartRateVariabilityMetadataList()[8]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(78, '08:34:00,48'), $instance->heartRateVariabilityMetadataList()[9]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(79, '08:34:03,52'), $instance->heartRateVariabilityMetadataList()[10]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(77, '08:34:04,30'), $instance->heartRateVariabilityMetadataList()[11]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:34:05,10'), $instance->heartRateVariabilityMetadataList()[12]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(74, '08:34:05,92'), $instance->heartRateVariabilityMetadataList()[13]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(74, '08:34:06,73'), $instance->heartRateVariabilityMetadataList()[14]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(73, '08:34:07,55'), $instance->heartRateVariabilityMetadataList()[15]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(73, '08:34:08,38'), $instance->heartRateVariabilityMetadataList()[16]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:34:09,18'), $instance->heartRateVariabilityMetadataList()[17]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(78, '08:34:09,95'), $instance->heartRateVariabilityMetadataList()[18]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(80, '08:34:13,03'), $instance->heartRateVariabilityMetadataList()[19]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:34:13,83'), $instance->heartRateVariabilityMetadataList()[20]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(79, '08:34:16,95'), $instance->heartRateVariabilityMetadataList()[21]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:34:17,75'), $instance->heartRateVariabilityMetadataList()[22]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:34:18,55'), $instance->heartRateVariabilityMetadataList()[23]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(73, '08:34:19,36'), $instance->heartRateVariabilityMetadataList()[24]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(75, '08:34:34,85'), $instance->heartRateVariabilityMetadataList()[25]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(77, '08:34:35,63'), $instance->heartRateVariabilityMetadataList()[26]);
    }
}
