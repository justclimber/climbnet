<?php
namespace App\Lib\Dicts\Presenter;

use App\Lib\Dicts\DictInterface;

class DictToSelect
{
    /**
     * @var DictInterface
     */
    private $dict;

    public function __construct(DictInterface $dict)
    {
        $this->dict = $dict;
    }

    public function forSelect(): array
    {
        $result = [];
        foreach ($this->dict->getDict() as $index => $value) {
            $result[] = [
                'text' => $value,
                'value' => $index,
            ];
        }
        return $result;
    }
}
