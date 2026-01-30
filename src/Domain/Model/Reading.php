<?php

namespace App\Domain\Model;

final readonly class Reading
{
    public function __construct(
        public string $client,
        public string $month,
        public int $value
    ) {}
}
