<?php

namespace App\Application\Service;

use App\Domain\Port\ReadingsLoaderInterface;
use App\Domain\Service\FraudDetector;

class DetectSuspiciousReadingsUseCase
{
    /**
     * using iterable to recieve all the registered adapters
     * @param iterable<ReadingsLoaderInterface> $loaders
     */
    public function __construct(
        private iterable $loaders,
        private FraudDetector $fraudDetector
    ) {}

    public function execute(string $filePath): array
    {
        // 1. get the adapter that supports the file
        $normalizedPath = str_replace('\\', '/', $filePath);
        $loader = null;

        foreach ($this->loaders as $l) {
            if ($l->supports($normalizedPath)) {
                $loader = $l;
                break;
            }
        }

        if (!$loader) {
            throw new \InvalidArgumentException("No adapter was found for the file: " . $normalizedPath);
        }

        // 2. load raw data
        $allReadings = $loader->load($filePath);
        $results = [];

        // 3. group the readings in sets of 12
        $chunks = array_chunk($allReadings, 12);

        foreach ($chunks as $clientReadings) {
            $analysis = $this->fraudDetector->check($clientReadings);

            foreach ($analysis['suspicious'] as $reading) {
                $results[] = [
                    'client' => $reading->client,
                    'month'  => $reading->month,
                    'value'  => $reading->value,
                    'median' => $analysis['median']
                ];
            }
        }

        return $results;
    }
}
