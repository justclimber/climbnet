<?php

namespace App\Lib\Cachable;

interface ModelInterface
{
    public function getCacheKey($postfix = null);

    public function getCachePrefix();

    public function getCacheTtl();

    public function invalidate($postfix = null);
}
