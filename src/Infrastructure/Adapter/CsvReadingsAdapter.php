<?php

namespace App\Infrastructure\Adapter;

use App\Domain\Model\Reading;
use App\Domain\Port\ReadingsLoaderInterface;

class CsvReadingsAdapter implements ReadingsLoaderInterface
{
    public function supports(string $filePath): bool
    {
        return str_ends_with(strtolower($filePath), '.csv');
    }

    public function load(string $filePath): array
    {
        $readings = [];

        if (($handle = fopen($filePath, "r")) !== false) {
            fgetcsv($handle);

            while (($data = fgetcsv($handle)) !== false) {
                $readings[] = new Reading($data[0], $data[1], (int)$data[2]);
            }

            fclose($handle);
        }

        return $readings;
    }
}
