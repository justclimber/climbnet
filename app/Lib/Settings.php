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

    const DICTS_FOR_SELECT = [
        RouteCategories::class,
        RouteTypes::class,
        AscentTypes::class,
    ];

    public function getAll()
    {
        return [
            'dicts' => $this->getDicts(),
            'selects' => $this->getDataForSelect(),
            'vk' => ['app_id' => config('services.vk.app_id')]
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

    public function getDataForSelect()
    {
        $dicts = [];
        foreach (self::DICTS_FOR_SELECT as $dictName) {
            /** @var DictInterface $dict */
            $dict = new $dictName();
            $dicts[$dict->getName()] = (new DictToSelect($dict))->forSelect();
        }

        return $dicts;
    }
}
