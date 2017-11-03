<?php

namespace App\Lib;

use App\Lib\Dicts\DictInterface;
use App\Lib\Dicts\RouteCategories;

class Settings
{
    const DICTS = [
        RouteCategories::class,
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
