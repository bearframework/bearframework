<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;
use BearFramework\App\CacheItem;

/**
 * Data cache
 * @event \BearFramework\App\Cache\ItemRequestEventDetails itemRequest An event dispatched after a cache item is requested.
 * @event \BearFramework\App\Cache\ItemChangeEventDetails itemChange An event dispatched after a cache item is changed.
 * @event \BearFramework\App\Cache\ItemSetEventDetails itemSet An event dispatched after a cache item is added or updated.
 * @event \BearFramework\App\Cache\ItemGetEventDetails itemGet An event dispatched after a cache item is requested.
 * @event \BearFramework\App\Cache\ItemGetValueEventDetails itemGetValue An event dispatched after the value of a cache item is requested.
 * @event \BearFramework\App\Cache\ItemExistsEventDetails itemExists An event dispatched after a cache item is checked for existence.
 * @event \BearFramework\App\Cache\ItemDeleteEventDetails itemDelete An event dispatched after a cache item is deleted.
 * @event null clear An event dispatched after the cache is cleared.
 */
class CacheRepository
{

    use \BearFramework\EventsTrait;

    /**
     *
     */
    private $newCacheItemCache = null;

    /**
     *
     * @var ?\BearFramework\App\ICacheDriver  
     */
    private $driver = null;

    /**
     * Enables the app cache driver. The cached data will be stored in the app data repository.
     * 
     * @param string $keyPrefix The key prefix for the cache items.
     * @return self Returns a reference to itself.
     */
    public function useAppDataDriver(string $keyPrefix = '.temp/cache/'): self
    {
        $app = App::get();
        $this->setDriver(new \BearFramework\App\DataCacheDriver($app->data, $keyPrefix));
        return $this;
    }

    /**
     * Enables the null cache driver. No data is stored and no errors are thrown.
     * 
     * @return self Returns a reference to itself.
     */
    public function useNullDriver(): self
    {
        $this->setDriver(new \BearFramework\App\NullCacheDriver());
        return $this;
    }

    /**
     * Sets a new cache driver.
     * 
     * @param \BearFramework\App\ICacheDriver $driver The driver to use for cache storage.
     * @return self Returns a reference to itself.
     * @throws \Exception
     */
    public function setDriver(\BearFramework\App\ICacheDriver $driver): self
    {
        if ($this->driver !== null) {
            throw new \Exception('A cache driver is already set!');
        }
        $this->driver = $driver;
        return $this;
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
     * @param string|null $key The key of the cache item.
     * @param mixed $value The value of the cache item.
     * @return \BearFramework\App\CacheItem Returns a new cache item.
     */
    public function make(?string $key = null, $value = null): \BearFramework\App\CacheItem
    {
        if ($this->newCacheItemCache === null) {
            $this->newCacheItemCache = new CacheItem();
        }
        $object = clone ($this->newCacheItemCache);
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
     * @return self Returns a reference to itself.
     */
    public function set(CacheItem $item): self
    {
        $driver = $this->getDriver();
        $driver->set($item->key, $item->value, $item->ttl);
        if ($this->hasEventListeners('itemSet')) {
            $this->dispatchEvent('itemSet', new \BearFramework\App\Cache\ItemSetEventDetails(clone ($item)));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Cache\ItemChangeEventDetails($item->key, 'set'));
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
        $driver = $this->getDriver();
        $item = null;
        $value = $driver->get($key);
        if ($value !== null) {
            $item = $this->make($key, $value);
        }
        if ($this->hasEventListeners('itemGet')) {
            $this->dispatchEvent('itemGet', new \BearFramework\App\Cache\ItemGetEventDetails($key, $item === null ? null : clone ($item)));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Cache\ItemRequestEventDetails($key, 'get'));
        }
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
        $driver = $this->getDriver();
        $value = $driver->get($key);
        if ($this->hasEventListeners('itemGetValue')) {
            $this->dispatchEvent('itemGetValue', new \BearFramework\App\Cache\ItemGetValueEventDetails($key, $value));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Cache\ItemRequestEventDetails($key, 'getValue'));
        }
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
        $driver = $this->getDriver();
        $exists = $driver->get($key) !== null;
        if ($this->hasEventListeners('itemExists')) {
            $this->dispatchEvent('itemExists', new \BearFramework\App\Cache\ItemExistsEventDetails($key, $exists));
        }
        if ($this->hasEventListeners('itemRequest')) {
            $this->dispatchEvent('itemRequest', new \BearFramework\App\Cache\ItemRequestEventDetails($key, 'exists'));
        }
        return $exists;
    }

    /**
     * Deletes an item from the cache.
     * 
     * @param string $key The key of the cache item.
     * @return self Returns a reference to itself.
     */
    public function delete(string $key): self
    {
        $driver = $this->getDriver();
        $driver->delete($key);
        if ($this->hasEventListeners('itemDelete')) {
            $this->dispatchEvent('itemDelete', new \BearFramework\App\Cache\ItemDeleteEventDetails($key));
        }
        if ($this->hasEventListeners('itemChange')) {
            $this->dispatchEvent('itemChange', new \BearFramework\App\Cache\ItemChangeEventDetails($key, 'delete'));
        }
        return $this;
    }

    /**
     * Deletes all values from the cache.
     * 
     * @return self Returns a reference to itself.
     */
    public function clear(): self
    {
        $driver = $this->getDriver();
        $driver->clear();
        if ($this->hasEventListeners('clear')) {
            $this->dispatchEvent('clear');
        }
        return $this;
    }
}
