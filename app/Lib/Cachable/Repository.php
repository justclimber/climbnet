<?php

namespace App\Lib\Cachable;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Builder;

class Repository
{
    /**
     * @var ModelInterface
     */
    protected $model;

    /**
     * @var int
     */
    protected $ttl;

    /**
     * @var string
     */
    protected $modelCachePrefix;

    protected $localCache = [];

    public function __construct(ModelInterface $model)
    {
        $this->model = $model;
        $this->ttl = $model->getCacheTtl();
        $this->modelCachePrefix = $model->getCachePrefix();
    }

    public static function factory($entityClassName)
    {
        $repositoryClassName = '\App\Model\Repositories\\' . class_basename($entityClassName);
        if (class_exists($repositoryClassName)) {
            return app($repositoryClassName);
        }

        throw new \Exception("You should declare $repositoryClassName");
    }

    public function getIdsByQuery(Builder $query)
    {
        return $query->get(['id'])->modelKeys();
    }

    /**
     * @param array $ids
     * @param Builder|null $query
     * @return Collection
     */
    public function getByIds(array $ids, Builder $query = null)
    {
        $modelsRaw = [];
        foreach ($ids as $id) {
            $modelsRaw[$id] = $this->tryGetCachedById($id);
        }

        $cacheMissed = array_filter($modelsRaw, function($row) {
            return is_null($row);
        });

        if ($cacheMissed) {
            if (!$query) {
                $query = $this->model->query();
            }
            $cacheMissedModels = $query->whereIn('id', array_keys($cacheMissed))->get()->getDictionary();

            $collection = new Collection();
            foreach ($ids as $id) {
                if (isset($modelsRaw[$id])) {
                    $collection->push($modelsRaw[$id]);
                } else {
                    if (!isset($cacheMissedModels[$id])) {
                        throw new
                            ModelNotFoundException("cant't find model with ID=$id in table {$this->model->getTable()}");
                    }
                    \Cache::put($this->getCacheKeyById($id), $cacheMissedModels[$id], $this->ttl);
                    $collection->push($cacheMissedModels[$id]);
                }
            }
        } else {
            $collection = Collection::make($modelsRaw);
        }

        return $collection;
    }

    protected function tryGetCachedById($id)
    {
        if (isset($this->localCache[$id])) {
            return $this->localCache[$id];
        }
        if ($result = \Cache::get($this->getCacheKeyById($id))) {
            $this->localCache[$id] = $result;
        }
        return $result;
    }

    public function invalidate(Model $model)
    {
        $model->invalidate();
        unset($this->localCache[$model->id]);
    }

    /**
     * Find in cache or in db in case of cache miss
     * Note: false hack is for caching nulls from db
     *
     * @param int $id
     * @param bool $orFail if true and the find result is false then throw ModelNotFoundException
     * @return Model|null
     */
    public function findCached($id, $orFail = false)
    {
        if (isset($this->localCache[$id])) {
            if ($orFail && !$this->localCache[$id]) {
                throw (new ModelNotFoundException)->setModel(get_class($this->model));
            }
            return $this->localCache[$id] ? : null;
        }

        $result = \Cache::remember($this->getCacheKeyById($id), $this->ttl, function () use ($id, $orFail) {
            if ($orFail) {
                return $this->findOrFail($id);
            }

            return $this->find($id) ? : false;
        });
        $this->localCache[$id] = $result;

        if ($orFail && !$result) {
            throw (new ModelNotFoundException)->setModel(get_class($this->model));
        }

        return $result ? : null;
    }

    protected function find($id)
    {
        return $this->model->find($id);
    }

    protected function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }

    protected function getCacheKeyById($id)
    {
        return $this->modelCachePrefix . $id;
    }
}
