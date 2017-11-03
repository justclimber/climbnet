<?php
namespace App\Lib\Dicts;

interface DictInterface
{
    /**
     * Return all values of the dict
     *
     * @return array
     */
    public function getDict();

    /**
     * Get name of the dict
     *
     * @return string
     */
    public function getName();
}
