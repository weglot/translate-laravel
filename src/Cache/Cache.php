<?php

namespace Weglot\Translate\Cache;

use Cache\Adapter\Illuminate\IlluminateCachePool;
use Illuminate\Cache\FileStore;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Filesystem\Filesystem;
use Psr\Cache\CacheItemPoolInterface;

/**
 * Class Cache
 * @package Weglot\Translate\Cache
 */
class Cache
{
    /**
     * @var string
     */
    protected $directory;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var Store
     */
    protected $store;

    /**
     * @var CacheItemPoolInterface
     */
    protected $itemCachePool;

    /**
     * Cache constructor.
     */
    public function __construct()
    {
        $this->directory = $this->makeCacheDirectory();
        $this->init();
    }

    /**
     * Initialize CacheItemPool
     */
    protected function init()
    {
        list($filesystem, $store, $itemCachePool) = $this->makeCacheItemPool();

        $this->filesystem = $filesystem;
        $this->store = $store;
        $this->itemCachePool = $itemCachePool;
    }

    /**
     * @param $directory
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;
        $this->init();

        return $this;
    }

    /**
     * @return string
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * @return Store
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @return CacheItemPoolInterface
     */
    public function getItemCachePool()
    {
        return $this->itemCachePool;
    }

    /**
     * @return array[Filesystem, FileStore, IlluminateCachePool]
     */
    protected function makeCacheItemPool()
    {
        $filesystem = new Filesystem();
        $store = new FileStore($filesystem, $this->getDirectory());
        $itemCachePool = new IlluminateCachePool($store);

        return [$filesystem, $store, $itemCachePool];
    }

    /**
     * @return string
     */
    protected function makeCacheDirectory()
    {
        $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'weglot-cache' . DIRECTORY_SEPARATOR . 'translations';
        if (!file_exists($directory)) {
            @mkdir($directory, 0777, true);
        }
        $directory .= DIRECTORY_SEPARATOR;
        return $directory;
    }
}
