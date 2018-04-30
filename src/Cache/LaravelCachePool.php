<?php

namespace Weglot\Translate\Cache;

use Cache\Adapter\Common\AbstractCachePool;
use Cache\Adapter\Common\PhpCacheItem;
use Cache\Hierarchy\HierarchicalCachePoolTrait;
use Cache\Hierarchy\HierarchicalPoolInterface;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Cache;

/**
 * Class LaravelCachePool
 * @package Weglot\Translate\Cache
 */
class LaravelCachePool extends AbstractCachePool implements HierarchicalPoolInterface
{
    use HierarchicalCachePoolTrait;

    /**
     * @type Repository
     */
    protected $repository;

    /**
     * LaravelCachePool constructor.
     */
    public function __construct()
    {
        $this->repository = Cache::store();
    }

    /**
     * {@inheritdoc}
     */
    protected function fetchObjectFromCache($key)
    {
        if (false === $result = unserialize($this->repository->get($this->getHierarchyKey($key)))) {
            return [false, null, [], null];
        }
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    protected function clearAllObjectsFromCache()
    {
        return $this->repository->clear();
    }

    /**
     * {@inheritdoc}
     */
    protected function clearOneObjectFromCache($key)
    {
        $path      = null;
        $keyString = $this->getHierarchyKey($key, $path);
        if ($path) {
            $this->repository->increment($path);
        }
        $this->clearHierarchyKeyCache();
        return $this->repository->delete($keyString);
    }

    /**
     * {@inheritdoc}
     * @throws \Exception
     */
    protected function storeItemInCache(PhpCacheItem $item, $ttl)
    {
        if ($ttl < 0) {
            return false;
        }
        $key  = $this->getHierarchyKey($item->getKey());
        $data = serialize([true, $item->get(), $item->getTags(), $item->getExpirationTimestamp()]);
        if ($ttl === null || $ttl === 0) {
            return $this->repository->set($key, $data);
        }
        $interval = new \DateInterval('PT' .$ttl. 'S');
        $this->repository->put($key, $data, $interval);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getDirectValue($key)
    {
        return $this->repository->get($key);
    }

    /**
     * {@inheritdoc}
     */
    protected function appendListItem($name, $value)
    {
        $list = $this->getList($name);
        $list[] = $value;

        $this->repository->put($name, serialize($list));
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getList($name)
    {
        if (!$this->repository->has($name)) {
            $this->repository->put($name, serialize([]));
        }

        return unserialize($this->repository->get($name));
    }

    /**
     * {@inheritdoc}
     */
    protected function removeList($name)
    {
        return $this->repository->delete($name);
    }

    /**
     * {@inheritdoc}
     */
    protected function removeListItem($name, $value)
    {
        $list = $this->getList($name);
        foreach ($list as $i => $item) {
            if ($item === $value) {
                unset($list[$i]);
            }
        }

        $this->repository->put($name, serialize($list));
        return true;
    }
}
