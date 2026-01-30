<?php

namespace App\Domain\Service;

use App\Domain\Model\Reading;

class FraudDetector
{
    /**
     * @param Reading[] $readings the 12 client's readings
     * @return array{suspicious: Reading[], median: float}
     */
    public function check(array $readings): array
    {
        if (count($readings) === 0) {
            return ['suspicious' => [], 'median' => 0.0];
        }

        $values = array_map(fn(Reading $r) => $r->value, $readings);
        $median = $this->calculateMedian($values);

        $upperLimit = $median * 1.5;
        $lowerLimit = $median * 0.5;

        $suspiciousReadings = array_filter($readings, function (Reading $r) use ($upperLimit, $lowerLimit) {
            return $r->value > $upperLimit || $r->value < $lowerLimit;
        });

        return [
            'suspicious' => array_values($suspiciousReadings),
            'median' => $median
        ];
    }

    private function calculateMedian(array $values): float
    {
        sort($values);
        $count = count($values);
        $middleIndex = (int) floor(($count - 1) / 2);

        if ($count % 2) {
            return (float) $values[$middleIndex];
        }

        return ($values[$middleIndex] + $values[$middleIndex + 1]) / 2;
    }
}
