<?php

namespace App\Infrastructure\Adapter;

use App\Domain\Model\Reading;
use App\Domain\Port\ReadingsLoaderInterface;

class XmlReadingsAdapter implements ReadingsLoaderInterface
{
    public function supports(string $filePath): bool
    {
        return str_ends_with(strtolower($filePath), '.xml');
    }

    public function load(string $filePath): array
    {
        $xml = simplexml_load_file($filePath);
        $readings = [];

        foreach ($xml->reading as $item) {
            $readings[] = new Reading(
                (string) $item->attributes()->clientID,
                (string) $item->attributes()->period,
                (int) $item);
        }

        return $readings;
    }
}
