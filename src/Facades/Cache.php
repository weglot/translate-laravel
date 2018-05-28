<?php

namespace Weglot\Translate\Facades;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Facades\Facade;
use Illuminate\Filesystem\Filesystem;
use Psr\Cache\CacheItemPoolInterface;
use Weglot\Translate\Cache\Cache as CacheService;

/**
 * Class Cache
 * @package Weglot\Translate\Cache
 *
 * @see \Weglot\Translate\Cache\Cache
 *
 * @method static string getDirectory();
 * @method static CacheService setDirectory(string $directory);
 * @method static Filesystem getFilesystem();
 * @method static Store getStore();
 * @method static CacheItemPoolInterface getItemCachePool();
 */
class Cache extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'weglot.cache';
    }
}
