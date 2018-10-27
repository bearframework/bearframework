<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
     * @var ?\BearFramework\App\ICacheDriver  
     */
    private $driver = null;

    /**
     * Enables the app cache driver. The cached data will be stored in the app data repository.
     * 
     * @return void No value is returned.
     */
    public function useAppDataDriver(): void
    {
        $app = App::get();
        $this->setDriver(new \BearFramework\App\DataCacheDriver($app->data));
    }

    /**
     * Sets a new cache driver.
     * 
     * @param \BearFramework\App\ICacheDriver $driver The driver to use for cache storage.
     * @return void No value is returned.
     * @throws \Exception
     */
    public function setDriver(\BearFramework\App\ICacheDriver $driver): void
    {
        if ($this->driver !== null) {
            throw new \Exception('A cache driver is already set!');
        }
        $this->driver = $driver;
    }

    /**
     * Returns the cache driver.
     * 
     * @return \BearFramework\App\ICacheDriver
     * @throws \Exception
     */
    private function getDriver(): \BearFramework\App\ICacheDriver
    {
        if ($this->driver !== null) {
            return $this->driver;
        }
        throw new \Exception('No cache driver specified! Use useAppDataDriver() or setDriver() to specify one.');
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
        $hooks = $app->hooks;
        $driver = $this->getDriver();

        $item = clone($item);
        $preventDefault = false;
        $hooks->execute('cacheItemSet', $item, $preventDefault);
        if (!$preventDefault) {
            $driver->set($item->key, $item->value, $item->ttl);
        }
        $hooks->execute('cacheItemSetDone', $item);
        $key = $item->key;
        $hooks->execute('cacheItemChanged', $key);
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
        $hooks = $app->hooks;
        $driver = $this->getDriver();

        $item = null;
        $returnValue = null;
        $preventDefault = false;
        $hooks->execute('cacheItemGet', $key, $returnValue, $preventDefault);
        if ($returnValue instanceof \BearFramework\App\CacheItem) {
            $item = $returnValue;
        } else {
            if (!$preventDefault) {
                $value = $driver->get($key);
                if ($value !== null) {
                    $item = $this->make($key, $value);
                }
            }
        }
        $hooks->execute('cacheItemGetDone', $key, $item);
        $hooks->execute('cacheItemRequested', $key);
        return $item;
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
        $hooks = $app->hooks;
        $driver = $this->getDriver();

        $value = null;
        $returnValue = null;
        $preventDefault = false;
        $hooks->execute('cacheItemGetValue', $key, $returnValue, $preventDefault);
        if ($returnValue !== null) {
            $value = $returnValue;
        } else {
            if (!$preventDefault) {
                $value = $driver->get($key);
            }
        }
        $hooks->execute('cacheItemGetValueDone', $key, $value);
        $hooks->execute('cacheItemRequested', $key);
        return $value;
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
        $hooks = $app->hooks;
        $driver = $this->getDriver();

        $returnValue = null;
        $hooks->execute('cacheItemExists', $key, $returnValue);
        if (is_bool($returnValue)) {
            $exists = $returnValue;
        } else {
            $exists = $driver->get($key) !== null;
        }

        $hooks->execute('cacheItemExistsDone', $key, $exists);
        $hooks->execute('cacheItemRequested', $key);
        return $exists;
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
        $hooks = $app->hooks;
        $driver = $this->getDriver();

        $preventDefault = false;
        $hooks->execute('cacheItemDelete', $key, $preventDefault);
        if (!$preventDefault) {
            $driver->delete($key);
        }
        $hooks->execute('cacheItemDeleteDone', $key);
        $hooks->execute('cacheItemChanged', $key);
        return $this;
    }

    /**
     * Deletes all values from the cache.
     */
    public function clear(): \BearFramework\App\CacheRepository
    {
        $app = App::get();
        $hooks = $app->hooks;
        $driver = $this->getDriver();

        $preventDefault = false;
        $hooks->execute('cacheClear', $preventDefault);
        if (!$preventDefault) {
            $driver->clear();
        }
        $hooks->execute('cacheClearDone');
        return $this;
    }

}
