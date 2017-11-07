<?php

namespace App\Lib;

use App\Lib\Dicts\DictInterface;
use App\Lib\Dicts\RouteCategories;
use App\Lib\Dicts\RouteTypes;

class Settings
{
    const DICTS = [
        RouteCategories::class,
        RouteTypes::class,
    ];

    public function getAll()
    {
        return [
            'dicts' => $this->getDicts()
        ];
    }

    public function getDicts()
    {
        $dicts = [];
        foreach (self::DICTS as $dictName) {
            /** @var DictInterface $dict */
            $dict = new $dictName();
            $dicts[$dict->getName()] = $dict->getDict();
        }

        return $dicts;
    }
}
