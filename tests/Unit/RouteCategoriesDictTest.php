<?php

namespace Tests\Unit;

use App\Lib\Dicts\RouteCategories;
use Tests\TestCase;

class RouteCategoriesDictTest extends TestCase
{
    /**
     * @var \App\Lib\Dicts\RouteCategories
     */
    private $routeCategoryDicts;

    public function setUp()
    {
        $this->routeCategoryDicts = new RouteCategories();
    }

    public function testGetDictContent()
    {
        $dictData = $this->routeCategoryDicts->getDict();
        $this->assertInternalType('array', $dictData);
        $this->assertContains('6a', $dictData);
        $this->assertContains('9c', $dictData);
        $this->assertNotContains('9c+', $dictData);
        $this->assertNotContains('4a', $dictData);
        $this->assertGreaterThan(array_search('7a', $dictData), array_search('8a', $dictData));
    }
}
