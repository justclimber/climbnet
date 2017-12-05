<?php

namespace App\Lib\Dicts;

class AscentTypes implements DictInterface
{
    const TYPE_ONSIGHT = 1;
    const TYPE_FLASH = 2;
    const TYPE_RED_POINT = 3;
    const TYPE_ATTEMPT = 4;
    const TYPE_INCOMPLETE = 5;

    public function getName()
    {
        return 'ascent_types';
    }

    public function getDict()
    {
        return [
            self::TYPE_ONSIGHT => 'Onsight',
            self::TYPE_FLASH => 'Flash',
            self::TYPE_RED_POINT => 'Red Point',
            self::TYPE_ATTEMPT => 'Attempt',
            self::TYPE_INCOMPLETE => 'Incomplete',
        ];
    }
}
