<?php

declare(strict_types=1);

namespace JDecool\HKParser;

use Generator;
use JDecool\HKParser\Exception\FileNotFound;
use JDecool\HKParser\Exception\InvalidXml;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use SimpleXMLElement;

class HealthKitParser
{
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
     */
    public function lines(): Generator
    {
        foreach ($this->xml as $line) {
            switch ($tag = $line['type'][0] ?? '') {
                case HKQuantityTypeIdentifierActiveEnergyBurned::name():
                    yield HKQuantityTypeIdentifierActiveEnergyBurned::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierAppleExerciseTime::name():
                    yield HKQuantityTypeIdentifierAppleExerciseTime::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierBasalEnergyBurned::name():
                    yield HKQuantityTypeIdentifierBasalEnergyBurned::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierBodyMass::name():
                    yield HKQuantityTypeIdentifierBodyMass::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierDistanceWalkingRunning::name():
                    yield HKQuantityTypeIdentifierDistanceWalkingRunning::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierFlightsClimbed::name():
                    yield HKQuantityTypeIdentifierFlightsClimbed::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierHeartRate::name():
                    yield HKQuantityTypeIdentifierHeartRate::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierHeartRateVariabilitySDNN::name():
                    yield HKQuantityTypeIdentifierHeartRateVariabilitySDNN::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierHeight::name():
                    yield HKQuantityTypeIdentifierHeight::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierRestingHeartRate::name():
                    yield HKQuantityTypeIdentifierRestingHeartRate::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierStepCount::name():
                    yield HKQuantityTypeIdentifierStepCount::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierVO2Max::name():
                    yield HKQuantityTypeIdentifierVO2Max::fromXml($line);
                    break;

                case HKQuantityTypeIdentifierWalkingHeartRateAverage::name():
                    yield HKQuantityTypeIdentifierWalkingHeartRateAverage::fromXml($line);
                    break;

                default:
                    $this->logger->warning('Unknow tag', [
                        'tag' => $tag,
                    ]);
                    continue 2;
            }
        }
    }
}
