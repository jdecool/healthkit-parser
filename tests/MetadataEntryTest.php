<?php

declare(strict_types=1);

namespace JDecool\HKParser\Tests;

use JDecool\HKParser\MetadataEntry;
use PHPUnit\Framework\TestCase;
use SimpleXMLElement;

class MetadataEntryTest extends TestCase
{
    public function testParseXml()
    {
        $xml = <<<XML
<MetadataEntry key="foo" value="bar"/>
XML;

        $instance = MetadataEntry::fromXml(new SimpleXMLElement($xml));
        $this->assertInstanceOf(MetadataEntry::class, $instance);
        $this->assertSame('foo', $instance->key());
        $this->assertSame('bar', $instance->value());
    }

    public function testConstructor()
    {
        $instance = new MetadataEntry('foo', 'bar');
        $this->assertInstanceOf(MetadataEntry::class, $instance);
        $this->assertSame('foo', $instance->key());
        $this->assertSame('bar', $instance->value());
    }
}
