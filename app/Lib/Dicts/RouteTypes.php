<?php

namespace App\Lib\Dicts;

class RouteTypes implements DictInterface
{
    const TYPE_LEAD = 1;
    const TYPE_TOP_ROPE = 2;
    const TYPE_BOLDERING = 3;
    const TYPE_TRAD = 4;

    public function getName()
    {
        return 'route_types';
    }

    public function getDict()
    {
        return [
            self::TYPE_LEAD => 'Lead',
            self::TYPE_TOP_ROPE => 'Top Rope',
            self::TYPE_BOLDERING => 'Bouldering',
            self::TYPE_TRAD => 'Trad',
        ];
    }
}
