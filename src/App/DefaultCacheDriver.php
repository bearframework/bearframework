<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * The default cache driver. It uses the $app->data to store the values.
 */
class DefaultCacheDriver implements \BearFramework\App\ICacheDriver
{

    /**
     * Stores a value in the cache.
     * 
     * @param string $key The key under which to store the value.
     * @param type $value The value to store.
     * @param int $ttl Number of seconds to store value in the cache.
     * @return void No value is returned.
     */
    public function set(string $key, $value, int $ttl = null): void
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $key = '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2';
        $app->data->setValue($key, gzcompress(serialize([$ttl > 0 ? time() + $ttl : 0, $value])));
    }

    /**
     * Retrieves a value from the cache.
     * 
     * @param string $key The key under which the value is stored.
     * @return mixed|null Returns the stored value or null if not found or expired.
     */
    public function get(string $key)
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $value = $app->data->getValue('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
        if ($value !== null) {
            try {
                $value = unserialize(gzuncompress($value));
                if ($value[0] > 0) {
                    if ($value[0] > time()) {
                        return $value[1];
                    }
                    return null;
                }
                return $value[1];
            } catch (\Exception $e) {
                
            }
        }
        return null;
    }

    /**
     * Deletes a value from the cache.
     * 
     * @param string $key The key under which the value is stored.
     * @return void No value is returned.
     */
    public function delete(string $key): void
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $app->data->delete('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
    }

    /**
     * Stores multiple values in the cache.
     * 
     * @param array $items An array of key/value pairs to store in the cache.
     * @param int $ttl Number of seconds to store values in the cache.
     * @return void No value is returned.
     */
    public function setMultiple(array $items, int $ttl = null): void
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    /**
     * Retrieves multiple values from the cache.
     * 
     * @param array $keys The keys under which the values are stored.
     * @return array An array (key/value) of found items.
     */
    public function getMultiple(array $keys): array
    {
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get($key);
        }
        return $results;
    }

    /**
     * Deletes multiple values from the cache.
     * 
     * @param array $keys The keys under which the values are stored.
     */
    public function deleteMultiple(array $keys): void
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

    /**
     * Deletes all values from the cache.
     */
    public function clear(): void
    {
        $app = App::get();
        $list = $app->data->getList()
                ->filterBy('key', '.temp/cache/', 'startWith');
        foreach ($list as $item) {
            $app->data->delete($item->key);
        };
    }

}
