<?php

namespace App\Lib\Dicts;

class RouteCategories implements DictInterface
{
    const CATEGORY_MIN = 5;
    const CATEGORY_MAX = 9;

    public function getName()
    {
        return 'categories';
    }

    public function getDict()
    {
        $dict = [];
        $categoryIndex = self::CATEGORY_MIN;
        for ($category = self::CATEGORY_MIN; $category <= self::CATEGORY_MAX; $category++) {
            foreach (['a', 'a+', 'b', 'b+', 'c', 'c+'] as $subcategory) {
                $dict[$categoryIndex] = $category . $subcategory;
                $categoryIndex += 2;
            }
        }
        array_pop($dict); // 9с+ doesn't exist yet =)
        return $dict;
    }
}