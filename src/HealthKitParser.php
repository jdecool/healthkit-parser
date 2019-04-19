<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use DateTimeImmutable;
use Generator;
use JDecool\HKParser\Exception\FileNotFound;
use JDecool\HKParser\Exception\InvalidXml;
use JDecool\HKParser\Exception\RuntimeException;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use SimpleXMLElement;

class HealthKitParser
{
    public const TAG_RECORD = 'Record';

    private $xml;
    private $logger;
    private $locale;

    /** @var DateTimeImmutable|null */
    private $exportDate;

    public static function fromFile(string $path): self
    {
        if (!file_exists($path)) {
            throw FileNotFound::fromPath($path);
        }

        return self::fromString(file_get_contents($path));
    }

    public static function fromString(string $xml): self
    {
        try {
            $xml = new SimpleXMLElement($xml);
        } catch (\Throwable $e) {
            throw InvalidXml::parsingError($e);
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

        if ('HealthData' !== $xml->getName()) {
            throw InvalidXml::invalidHealthData();
        }

        $this->xml = $xml;
        $this->logger = $logger;
        $this->locale = (string) $xml['locale'];

        if (1 === $this->xml->ExportDate->count()) {
            $this->exportDate = new DateTimeImmutable((string) $this->xml->ExportDate['value']);
        }
    }

    public function locale(): string
    {
        return $this->locale;
    }

    public function exportDate(): ?DateTimeImmutable
    {
        return $this->exportDate;
    }

    /**
     * @return HKModel[]
     *
     * @throws InvalidXml
     */
    public function lines(): Generator
    {
        foreach ($this->xml as $line) {
            if (null !== ($model = $this->parseLine($line))) {
                yield $model;
            }
        }
    }

    /**
     * @return HKModel[]
     *
     * @throws InvalidXml
     */
    public function read(string $tag): Generator
    {
        foreach ($this->xml->$tag as $line) {
            if (null !== ($model = $this->parseLine($line))) {
                yield $model;
            }
        }
    }

    private function parseLine(SimpleXMLElement $line): ?HKModel
    {
        $tag = $line->getName();
        switch ($tag) {
            case self::TAG_RECORD:
                return $this->parseTagRecord($line);
        }

        $this->logger->warning('Unknow tag', [
            'tag' => $tag,
        ]);

        return null;
    }

    /**
     * @throws InvalidXml
     */
    private function parseTagRecord(SimpleXMLElement $xml): Record
    {
        $recordType = $xml['type'][0] ?? '';
        if ('' === $recordType) {
            throw InvalidXml::misggingRecordType();
        }

        $tagParserClass = sprintf('%s\\%s', __NAMESPACE__, $recordType);
        if (class_exists($tagParserClass) && method_exists($tagParserClass, 'fromXml')) {
            return call_user_func([$tagParserClass, 'fromXml'], $xml);
        }

        throw RuntimeException::noParserImplemented("Record[@$recordType]");
    }
}
