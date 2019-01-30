<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use Generator;
use JDecool\HKParser\Exception\FileNotFound;
use JDecool\HKParser\Exception\InvalidXml;
use JDecool\HKParser\Exception\RuntimeException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use SimpleXMLElement;

class HealthKitParser
{
    private const TYPE_RECORD = 'Record';

    private $xml;
    private $logger;

    public static function fromFile(string $path): self
    {
        if (!file_exists($path)) {
            throw new FileNotFound($path);
        }

        return self::fromString(file_get_contents($path));
    }

    public static function fromString(string $xml): self
    {
        try {
            $xml = new SimpleXMLElement($xml);
        } catch (\Throwable $e) {
            throw new InvalidXml();
        }

        return self::fromXml($xml);
    }

    public static function fromXml(SimpleXMLElement $xml): self
    {
        return new self($xml);
    }

    private function __construct(SimpleXMLElement $xml, LoggerInterface $logger = null)
    {
        if (null === $logger) {
            $logger = new NullLogger();
        }

        $this->xml = $xml;
        $this->logger = $logger;
    }

    /**
     * @return HKModel[]
     *
     * @throws InvalidXml
     */
    public function lines(): Generator
    {
        foreach ($this->xml as $line) {
            $tag = $line->getName();
            switch ($tag) {
                case self::TYPE_RECORD:
                    yield $this->parseTagRecord($line);
                    break;

                default:
                    $this->logger->warning('Unknow tag', [
                        'tag' => $tag,
                    ]);
                    continue 2;
            }
        }
    }

    /**
     * @throws InvalidXml
     */
    private function parseTagRecord(SimpleXMLElement $xml): Record
    {
        $recordType = $xml['type'][0] ?? '';
        if ('' === $recordType) {
            throw new InvalidXml('Missing type on record type');
        }

        $tagParserClass = sprintf('%s\\%s', __NAMESPACE__, $recordType);
        if (class_exists($tagParserClass) && method_exists($tagParserClass, 'fromXml')) {
            return call_user_func([$tagParserClass, 'fromXml'], $xml);
        }

        throw new RuntimeException("No parser implemented for '$recordType' record type");
    }
}
