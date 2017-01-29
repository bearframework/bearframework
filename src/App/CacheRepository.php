<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App\CacheItem;

/**
 * Data cache
 */
class CacheRepository
{

    /**
     *
     */
    private static $newCacheItemCache = null;

    /**
     *
     */
    private $cacheDriver = null;

    /**
     * 
     * @param \BearFramework\App\ICacheDriver $cacheDriver The cache driver to use.
     */
    function __construct(ICacheDriver $cacheDriver)
    {
        $this->cacheDriver = $cacheDriver;
    }

    /**
     * Constructs a new cache item and returns it.
     * 
     * @var string|null $key The key of the cache item.
     * @var string|null $value The value of the cache item.
     * @return \BearFramework\App\CacheItem Returns a new cache item.
     */
    public function make(string $key = null, $value = null): \BearFramework\App\CacheItem
    {
        if (self::$newCacheItemCache === null) {
            self::$newCacheItemCache = new CacheItem();
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

    /**
     * Stores a cache item.
     * 
     * @param \BearFramework\App\CacheItem $item The cache item to store.
     * @return \BearFramework\App\CacheRepository A reference to itself.
     */
    public function set(CacheItem $item): \BearFramework\App\CacheRepository
    {
        $this->cacheDriver->set($item->key, $item->value, $item->ttl);
        return $this;
    }

    /**
     * Returns the cache item stored or null if not found.
     * 
     * @param string $key The key of the cache item.
     * @return \BearFramework\App\CacheItem|null The cache item stored or null if not found.
     */
    public function get(string $key): ?\BearFramework\App\CacheItem
    {
        $value = $this->cacheDriver->get($key);
        if ($value !== null) {
            return $this->make($key, $value);
        }
        return null;
    }

    /**
     * Returns the value of the cache item specified.
     * 
     * @param string $key The key of the cache item.
     * @return mixed The value of the cache item or null if not found.
     */
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
     * @param string $key The key of the cache item.
     * @return bool TRUE if the cache item exists in the cache, FALSE otherwise.
     */
    public function exists(string $key): bool
    {
        $value = $this->cacheDriver->get($key);
        return $value !== null;
    }

    /**
     * Deletes a cache from the cache.
     * 
     * @param string $key The key of the cache item.
     * @return \BearFramework\App\CacheRepository A reference to itself.
     */
    public function delete(string $key): \BearFramework\App\CacheRepository
    {
        $this->cacheDriver->delete($key);
        return $this;
    }

}
