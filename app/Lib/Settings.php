<?php

namespace App\Lib;

use App\Lib\Dicts\AscentTypes;
use App\Lib\Dicts\DictInterface;
use App\Lib\Dicts\Presenter\DictToSelect;
use App\Lib\Dicts\RouteCategories;
use App\Lib\Dicts\RouteTypes;

class Settings
{
    const DICTS = [
        RouteCategories::class,
        RouteTypes::class,
        AscentTypes::class,
    ];

    public function getAll()
    {
        return [
            'dicts' => $this->getDicts(),
            'vk' => ['app_id' => config('services.vk.app_id')]
        ];
    }

    public function getDicts()
    {
        $dicts = [];
        foreach (self::DICTS as $dictName) {
            /** @var DictInterface $dict */
            $dict = new $dictName();
            $dicts[$dict->getName()] = (new DictToSelect($dict))->forSelect();
        }

        return $dicts;
    }
}
