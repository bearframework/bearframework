<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App\CacheItem;
use BearFramework\App;

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
        $app = App::get();
        $this->cacheDriver->set($item->key, $item->value, $item->ttl);
        if ($app->hooks->exists('cacheItemChanged')) {
            $data = new \BearFramework\App\Hooks\CacheItemChangedData();
            $data->action = 'set';
            $data->key = $item->key;
            $app->hooks->execute('cacheItemChanged', $data);
        }
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
        $app = App::get();
        $value = $this->cacheDriver->get($key);
        if ($app->hooks->exists('cacheItemRequested')) {
            $data = new \BearFramework\App\Hooks\CacheItemRequestedData();
            $data->action = 'get';
            $data->key = $key;
            $data->exists = $value !== null;
            $app->hooks->execute('cacheItemRequested', $data);
        }
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
        $app = App::get();
        $value = $this->cacheDriver->get($key);
        if ($app->hooks->exists('cacheItemRequested')) {
            $data = new \BearFramework\App\Hooks\CacheItemRequestedData();
            $data->action = 'getValue';
            $data->key = $key;
            $data->exists = $value !== null;
            $app->hooks->execute('cacheItemRequested', $data);
        }
        if ($value !== null) {
            return $value;
        }
        return null;
    }

    /**
     * Returns information whether a key exists in the cache.
     * 
     * @param string $key The key of the cache item.
     * @return bool TRUE if the cache item exists in the cache, FALSE otherwise.
     */
    public function exists(string $key): bool
    {
        $app = App::get();
        $value = $this->cacheDriver->get($key);
        if ($app->hooks->exists('cacheItemRequested')) {
            $data = new \BearFramework\App\Hooks\CacheItemRequestedData();
            $data->action = 'exists';
            $data->key = $key;
            $data->exists = $value !== null;
            $app->hooks->execute('cacheItemRequested', $data);
        }
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
        $app = App::get();
        $this->cacheDriver->delete($key);
        if ($app->hooks->exists('cacheItemChanged')) {
            $data = new \BearFramework\App\Hooks\CacheItemChangedData();
            $data->action = 'delete';
            $data->key = $key;
            $app->hooks->execute('cacheItemChanged', $data);
        }
        return $this;
    }

    /**
     * Deletes all values from the cache.
     */
    public function clear(): \BearFramework\App\CacheRepository
    {
        $this->cacheDriver->clear();
        return $this;
    }

}
