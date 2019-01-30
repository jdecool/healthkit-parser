<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use DateTimeImmutable;
use JDecool\HKParser\Exception\FileNotFound;
use JDecool\HKParser\Exception\InvalidXml;
use JDecool\HKParser\Exception\RuntimeException;
use JDecool\HKParser\HealthKitParser;
use JDecool\HKParser\HKQuantityTypeIdentifierActiveEnergyBurned;
use JDecool\HKParser\HKQuantityTypeIdentifierAppleExerciseTime;
use JDecool\HKParser\HKQuantityTypeIdentifierBasalEnergyBurned;
use JDecool\HKParser\HKQuantityTypeIdentifierBodyMass;
use JDecool\HKParser\HKQuantityTypeIdentifierDistanceWalkingRunning;
use JDecool\HKParser\HKQuantityTypeIdentifierFlightsClimbed;
use JDecool\HKParser\HKQuantityTypeIdentifierHeartRate;
use JDecool\HKParser\HKQuantityTypeIdentifierHeartRateVariabilitySDNN;
use JDecool\HKParser\HKQuantityTypeIdentifierHeight;
use JDecool\HKParser\HKQuantityTypeIdentifierRestingHeartRate;
use JDecool\HKParser\HKQuantityTypeIdentifierStepCount;
use JDecool\HKParser\HKQuantityTypeIdentifierVO2Max;
use JDecool\HKParser\HKQuantityTypeIdentifierWalkingHeartRateAverage;
use JDecool\HKParser\InstantaneousBeatsPerMinute;
use JDecool\HKParser\MetadataEntry;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class HealthKitParserTest extends TestCase
{
    public function testCreateParserFromFile()
    {
        $parser = HealthKitParser::fromFile(__DIR__.'/../fixtures/exporter.xml');

        $this->assertInstanceOf(HealthKitParser::class, $parser);
        $this->assertInstanceOf(HKQuantityTypeIdentifierWalkingHeartRateAverage::class, $parser->lines()->current());
    }

    public function testExceptionThrowIfCreateParserWhithInvalidFilePath()
    {
        $this->expectException(FileNotFound::class);

        $parser = HealthKitParser::fromFile('/foo/bar.xml');
    }

    public function testCreateParserFromString()
    {
        $parser = HealthKitParser::fromString('<HealthData locale="fr_FR"></HealthData>');

        $this->assertInstanceOf(HealthKitParser::class, $parser);
    }

    public function testExceptionThrowIfCreateParserWithInvalidXmlString()
    {
        $this->expectException(InvalidXml::class);

        $parser = HealthKitParser::fromString('invalid xml');
    }

    public function testCreateParserFromXml()
    {
        $parser = HealthKitParser::fromXml(new SimpleXMLElement('<HealthData locale="fr_FR"></HealthData>'));

        $this->assertInstanceOf(HealthKitParser::class, $parser);
    }

    public function testParseFile()
    {
        $parser = HealthKitParser::fromFile(__DIR__.'/../fixtures/exporter.xml');
        $this->assertInstanceOf(HealthKitParser::class, $parser);

        $tags = [
            HKQuantityTypeIdentifierWalkingHeartRateAverage::class,
            HKQuantityTypeIdentifierVO2Max::class,
            HKQuantityTypeIdentifierStepCount::class,
            HKQuantityTypeIdentifierRestingHeartRate::class,
            HKQuantityTypeIdentifierHeight::class,
            HKQuantityTypeIdentifierHeartRateVariabilitySDNN::class,
            HKQuantityTypeIdentifierHeartRate::class,
            HKQuantityTypeIdentifierFlightsClimbed::class,
            HKQuantityTypeIdentifierDistanceWalkingRunning::class,
            HKQuantityTypeIdentifierBodyMass::class,
            HKQuantityTypeIdentifierBasalEnergyBurned::class,
            HKQuantityTypeIdentifierAppleExerciseTime::class,
            HKQuantityTypeIdentifierActiveEnergyBurned::class,
        ];

        foreach ($parser->lines() as $key => $value) {
            $this->assertInstanceOf($tags[$key], $value);
        }
    }

    public function testParseHKQuantityTypeIdentifierBasalEnergyBurnedTag()
    {

        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierBasalEnergyBurned" sourceName="Apple Watch" sourceVersion="5.0.1" device="&lt;&lt;HKDevice: 0x2830f4230&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1&gt;" unit="kcal" creationDate="2018-11-16 13:18:46 +0100" startDate="2018-10-28 02:25:14 +0100" endDate="2018-11-09 13:18:27 +0100" value="18087.8"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierBasalEnergyBurned::class, $tag);
        $this->assertSame('Apple Watch', $tag->sourceName());
        $this->assertSame('5.0.1', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2830f4230>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1>', $tag->device());
        $this->assertSame('kcal', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:18:46 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-10-28 02:25:14 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-09 13:18:27 +0100'), $tag->endDate());
        $this->assertSame('18087.8', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierAppleExerciseTimeTag()
    {

        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierAppleExerciseTime" sourceName="Apple Watch" sourceVersion="5.1.2" device="&lt;&lt;HKDevice: 0x2830d10e0&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2&gt;" unit="min" creationDate="2019-01-17 18:46:32 +0100" startDate="2019-01-17 18:45:27 +0100" endDate="2019-01-17 18:46:27 +0100" value="1"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierAppleExerciseTime::class, $tag);
        $this->assertSame('Apple Watch', $tag->sourceName());
        $this->assertSame('5.1.2', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2830d10e0>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2>', $tag->device());
        $this->assertSame('min', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2019-01-17 18:46:32 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-17 18:45:27 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-17 18:46:27 +0100'), $tag->endDate());
        $this->assertSame('1', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierActiveEnergyBurnedTag()
    {

        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierActiveEnergyBurned" sourceName="Apple Watch" sourceVersion="5.0.1" device="&lt;&lt;HKDevice: 0x283368230&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1&gt;" unit="kcal" creationDate="2018-11-16 13:18:46 +0100" startDate="2018-10-28 02:30:13 +0100" endDate="2018-11-09 13:18:27 +0100" value="0.058"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierActiveEnergyBurned::class, $tag);
        $this->assertSame('Apple Watch', $tag->sourceName());
        $this->assertSame('5.0.1', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x283368230>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1>', $tag->device());
        $this->assertSame('kcal', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:18:46 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-10-28 02:30:13 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-09 13:18:27 +0100'), $tag->endDate());
        $this->assertSame('0.058', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierBodyMassTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierBodyMass" sourceName="iPhone" sourceVersion="12.1" unit="kg" creationDate="2018-11-16 13:24:18 +0100" startDate="2018-11-16 13:24:18 +0100" endDate="2018-11-16 13:24:18 +0100" value="83"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierBodyMass::class, $tag);
        $this->assertSame('iPhone', $tag->sourceName());
        $this->assertSame('12.1', $tag->sourceVersion());
        $this->assertNull($tag->device());
        $this->assertSame('kg', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $tag->endDate());
        $this->assertSame('83', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierDistanceWalkingRunningTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierDistanceWalkingRunning" sourceName="Foo" sourceVersion="5.1.2" device="&lt;&lt;HKDevice: 0x2833a7250&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2&gt;" unit="km" creationDate="2019-01-11 18:10:12 +0100" startDate="2019-01-11 18:09:42 +0100" endDate="2019-01-11 18:10:10 +0100" value="0.0540796"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierDistanceWalkingRunning::class, $tag);
        $this->assertSame('Foo', $tag->sourceName());
        $this->assertSame('5.1.2', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2833a7250>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.2>', $tag->device());
        $this->assertSame('km', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 18:10:12 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 18:09:42 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2019-01-11 18:10:10 +0100'), $tag->endDate());
        $this->assertSame('0.0540796', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierFlightsClimbedTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierFlightsClimbed" sourceName="iPhone" sourceVersion="12.0" device="&lt;&lt;HKDevice: 0x2830f01e0&gt;, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone10,4, software:12.0&gt;" unit="count" creationDate="2018-09-30 20:19:34 +0100" startDate="2018-09-30 19:56:31 +0100" endDate="2018-09-30 19:56:34 +0100" value="1"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierFlightsClimbed::class, $tag);
        $this->assertSame('iPhone', $tag->sourceName());
        $this->assertSame('12.0', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2830f01e0>, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone10,4, software:12.0>', $tag->device());
        $this->assertSame('count', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-09-30 20:19:34 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-09-30 19:56:31 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-09-30 19:56:34 +0100'), $tag->endDate());
        $this->assertSame('1', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierHeartRateTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierHeartRate" sourceName="Apple Watch" sourceVersion="5.0.1" device="&lt;&lt;HKDevice: 0x2833968a0&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1&gt;" unit="count/min" creationDate="2018-11-16 13:36:42 +0100" startDate="2018-11-16 13:28:45 +0100" endDate="2018-11-16 13:28:45 +0100" value="90">
    <MetadataEntry key="HKMetadataKeyHeartRateMotionContext" value="0"/>
  </Record>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierHeartRate::class, $tag);
        $this->assertSame('Apple Watch', $tag->sourceName());
        $this->assertSame('5.0.1', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x2833968a0>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.0.1>', $tag->device());
        $this->assertSame('count/min', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:36:42 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:28:45 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:28:45 +0100'), $tag->endDate());
        $this->assertSame('90', $tag->value());
        $this->assertCount(1, $tag->metadata());
        $this->assertEquals(new MetadataEntry('HKMetadataKeyHeartRateMotionContext', '0'), $tag->metadata()[0]);
    }

    public function testParseHKQuantityTypeIdentifierHeartRateVariabilitySDNNTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierHeartRateVariabilitySDNN" sourceName="Apple Watch" sourceVersion="5.1.1" device="&lt;&lt;HKDevice: 0x283336ee0&gt;, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.1&gt;" unit="ms" creationDate="2018-11-19 08:34:44 +0100" startDate="2018-11-19 08:33:39 +0100" endDate="2018-11-19 08:34:44 +0100" value="25.5526">
    <HeartRateVariabilityMetadataList>
     <InstantaneousBeatsPerMinute bpm="78" time="08:33:44,67"/>
     <InstantaneousBeatsPerMinute bpm="71" time="08:33:48,87"/>
     <InstantaneousBeatsPerMinute bpm="80" time="08:33:55,04"/>
    </HeartRateVariabilityMetadataList>
  </Record>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierHeartRateVariabilitySDNN::class, $tag);
        $this->assertSame('Apple Watch', $tag->sourceName());
        $this->assertSame('5.1.1', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x283336ee0>, name:Apple Watch, manufacturer:Apple, model:Watch, hardware:Watch4,2, software:5.1.1>', $tag->device());
        $this->assertSame('ms', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-19 08:34:44 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-19 08:33:39 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-19 08:34:44 +0100'), $tag->endDate());
        $this->assertSame('25.5526', $tag->value());
        $this->assertCount(0, $tag->metadata());

        $this->assertCount(3, $tag->heartRateVariabilityMetadataList());
        $this->assertEquals(new InstantaneousBeatsPerMinute(78, '08:33:44,67'), $tag->heartRateVariabilityMetadataList()[0]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(71, '08:33:48,87'), $tag->heartRateVariabilityMetadataList()[1]);
        $this->assertEquals(new InstantaneousBeatsPerMinute(80, '08:33:55,04'), $tag->heartRateVariabilityMetadataList()[2]);
    }

    public function testParseHKQuantityTypeIdentifierHeightTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierHeight" sourceName="Foo" sourceVersion="12.1" unit="cm" creationDate="2018-11-16 13:24:18 +0100" startDate="2018-11-16 13:24:18 +0100" endDate="2018-11-16 13:24:18 +0100" value="183"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierHeight::class, $tag);
        $this->assertSame('Foo', $tag->sourceName());
        $this->assertSame('12.1', $tag->sourceVersion());
        $this->assertNull($tag->device());
        $this->assertSame('cm', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-11-16 13:24:18 +0100'), $tag->endDate());
        $this->assertSame('183', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierRestingHeartRateTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierRestingHeartRate" sourceName="Apple Watch" sourceVersion="5.1.1" unit="count/min" creationDate="2018-11-30 21:11:57 +0100" startDate="2018-11-30 06:13:30 +0100" endDate="2018-11-30 21:06:16 +0100" value="49"/>
</HealthData>
XML
);

        $instance = $parser->lines()->current();
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

    public function testParseHKQuantityTypeIdentifierStepCountTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierStepCount" sourceName="iPhone" sourceVersion="9.3.2" device="&lt;&lt;HKDevice: 0x28301c1e0&gt;, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone8,4, software:9.3.2&gt;" unit="count" creationDate="2016-07-11 23:03:23 +0100" startDate="2016-07-11 21:58:42 +0100" endDate="2016-07-11 21:59:05 +0100" value="14"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierStepCount::class, $tag);
        $this->assertSame('iPhone', $tag->sourceName());
        $this->assertSame('9.3.2', $tag->sourceVersion());
        $this->assertSame('<<HKDevice: 0x28301c1e0>, name:iPhone, manufacturer:Apple, model:iPhone, hardware:iPhone8,4, software:9.3.2>', $tag->device());
        $this->assertSame('count', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2016-07-11 23:03:23 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2016-07-11 21:58:42 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2016-07-11 21:59:05 +0100'), $tag->endDate());
        $this->assertSame('14', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testParseHKQuantityTypeIdentifierVO2MaxTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierVO2Max" sourceName="Apple Watch" unit="mL/min·kg" creationDate="2018-12-08 17:19:30 +0100" startDate="2018-12-08 17:19:30 +0100" endDate="2018-12-08 17:19:30 +0100" value="42.095">
    <MetadataEntry key="HKVO2MaxTestType" value="2"/>
  </Record>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierVO2Max::class, $tag);
        $this->assertSame('Apple Watch', $tag->sourceName());
        $this->assertNull($tag->sourceVersion());
        $this->assertNull($tag->device());
        $this->assertSame('mL/min·kg', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-12-08 17:19:30 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-08 17:19:30 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-08 17:19:30 +0100'), $tag->endDate());
        $this->assertSame('42.095', $tag->value());
        $this->assertCount(1, $tag->metadata());
        $this->assertEquals(new MetadataEntry('HKVO2MaxTestType', '2'), $tag->metadata()[0]);
    }

    public function testParseHKQuantityTypeIdentifierWalkingHeartRateAverageTag()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="HKQuantityTypeIdentifierWalkingHeartRateAverage" sourceName="Apple Watch" sourceVersion="5.1.2" unit="count/min" creationDate="2018-12-22 00:33:44 +0100" startDate="2018-12-21 08:03:56 +0100" endDate="2018-12-21 18:55:21 +0100" value="107.5"/>
</HealthData>
XML
);

        $tag = $parser->lines()->current();
        $this->assertInstanceOf(HKQuantityTypeIdentifierWalkingHeartRateAverage::class, $tag);
        $this->assertSame('Apple Watch', $tag->sourceName());
        $this->assertSame('5.1.2', $tag->sourceVersion());
        $this->assertNull($tag->device());
        $this->assertSame('count/min', $tag->unit());
        $this->assertEquals(new DateTimeImmutable('2018-12-22 00:33:44 +0100'), $tag->creationDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-21 08:03:56 +0100'), $tag->startDate());
        $this->assertEquals(new DateTimeImmutable('2018-12-21 18:55:21 +0100'), $tag->endDate());
        $this->assertSame('107.5', $tag->value());
        $this->assertCount(0, $tag->metadata());
    }

    public function testExceptionThrowIfEmptyRecordTypeIsParsed()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record sourceName="Apple Watch" sourceVersion="5.1.2" unit="count/min" creationDate="2018-12-22 00:33:44 +0100" startDate="2018-12-21 08:03:56 +0100" endDate="2018-12-21 18:55:21 +0100" value="107.5"/>
</HealthData>
XML
);

        $this->expectException(InvalidXml::class);
        $this->expectExceptionMessage('Missing type on record type');

        $tag = $parser->lines()->current();
    }

    public function testExceptionThrowIfUnknowRecordTypeIsParsed()
    {
        $parser = HealthKitParser::fromString(<<<XML
<HealthData locale="fr_FR">
  <Record type="UnknowRecordType" sourceName="Apple Watch" sourceVersion="5.1.2" unit="count/min" creationDate="2018-12-22 00:33:44 +0100" startDate="2018-12-21 08:03:56 +0100" endDate="2018-12-21 18:55:21 +0100" value="107.5"/>
</HealthData>
XML
);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage("No parser implemented for 'UnknowRecordType' record type");

        $tag = $parser->lines()->current();
    }
}
