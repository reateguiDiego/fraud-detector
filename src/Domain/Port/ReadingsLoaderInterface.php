<?php

namespace App\Domain\Port;

use App\Domain\Model\Reading;

interface ReadingsLoaderInterface
{
    /**
     * @return Reading[]
     */
    public function load(string $filePath): array;

    /**
     * Checks if this adapter can read the file
     */
    public function supports(string $filePath): bool;
}
