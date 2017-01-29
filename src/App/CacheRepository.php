<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;
use BearFramework\App\CacheItem;

/**
 * Data cache
 */
class CacheRepository
{

    private static $newCacheItemCache = null;
    private $cacheDriver = null;

    function __construct(ICacheDriver $cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;
    }

    /**
     * 
     * @return \BearFramework\App\CacheItem
     */
    public function make(string $key = null, $value = null): \BearFramework\App\CacheItem
    {
        if (self::$newCacheItemCache === null) {
            self::$newCacheItemCache = new \BearFramework\App\CacheItem();
        }
        $object = clone(self::$newCacheItemCache);
        if ($key !== null) {
            $object->key = $key;
        }
        if ($value !== null) {
            $object->value = $value;
        }
        return $object;
    }

    public function set(CacheItem $item): \BearFramework\App\CacheRepository
    {
        $this->cacheDriver->set($item->key, $item->value, $item->ttl);
        return $this;
    }

    /**
     * Return the saved data from the cache or the default value specified
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\CacheItem|null The saved data from the cache or the default value specified
     */
    public function get(string $key): ?\BearFramework\App\CacheItem
    {
        $value = $this->cacheDriver->get($key);
        if ($value !== null) {
            return $this->make($key, $value);
        }
        return null;
    }

    public function getValue(string $key)
    {
        $cacheItem = $this->get($key);
        if ($cacheItem === null) {
            return null;
        }
        return $cacheItem->value;
    }

    /**
     * Returns information whether a key exists in the cache.
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return bool TRUE if the key exists in the cache, FALSE otherwise.
     */
    public function exists(string $key): bool
    {
        $value = $this->cacheDriver->get($key);
        return $value !== null;
    }

    /**
     * Deletes data from the cache
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\CacheRepository
     */
    public function delete(string $key): \BearFramework\App\CacheRepository
    {
        $this->cacheDriver->delete($key);
        return $this;
    }

}
