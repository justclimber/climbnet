<?php

namespace App\Lib\Cachable;

/**
 * @property int $id
 * @mixin \Eloquent
 */
trait ModelTrait
{
    public function invalidate($postfix = null)
    {
        \Cache::forget($this->getCacheKey($postfix));

        return $this;
    }

    public function getCacheKey($postfix = null)
    {
        return $this->getCachePrefix() . $this->id . ($postfix ? "_$postfix" : '');
    }

    public function getCachePrefix()
    {
        return $this->getTable() . '_';
    }

    public function getCacheTtl()
    {
        return config('cache.ttl.models');
    }

    public static function bootCachableTrait()
    {
        static::created(function (ModelInterface $model) {
            \Cache::put($model->getCacheKey(), $model, $model->getCacheTtl());
        });
        static::updated(function (ModelInterface $model) {
            Repository::factory(get_class($model))->invalidate($model);
        });
        static::deleted(function (ModelInterface $model) {
            Repository::factory(get_class($model))->invalidate($model);
        });
    }
}
