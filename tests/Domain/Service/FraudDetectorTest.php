<?php

namespace App\Tests\Domain\Service;

use App\Domain\Model\Reading;
use App\Domain\Service\FraudDetector;
use PHPUnit\Framework\TestCase;

class FraudDetectorTest extends TestCase
{
    public function testItDetectsSuspiciousReadings(): void
    {
        $detector = new FraudDetector();
        $readings = [];

        // set 10 regular readings
        for ($i = 0; $i < 10; $i++) {
            $readings[] = new Reading('client-1', sprintf('2026-%02d', $i + 1), 100);
        }

        // set 2 suspicious readings above and under the median
        $readings[] = new Reading('client-1', '2026-11', 200);
        $readings[] = new Reading('client-1', '2026-12', 40);

        $result = $detector->check($readings);

        $this->assertCount(2, $result['suspicious']);
        $this->assertEquals(100, $result['median']);
        $this->assertEquals(200, $result['suspicious'][0]->value);
        $this->assertEquals(40, $result['suspicious'][1]->value);
    }
}
