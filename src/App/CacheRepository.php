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

    public function set(CacheItem $item): \BearFramework\App\CacheRepository
    {
        $ttl = is_int($item->ttl) ? $item->ttl : 0;
        $app = App::get();
        $keyMD5 = md5($item->key);
        $key = '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2';
        $app->data->setValue($key, gzcompress(serialize([$ttl > 0 ? time() + $ttl : 0, $item->value])));
        return $this;
    }

    /**
     * Return the saved data from the cache or the default value specified
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return mixed The saved data from the cache or the default value specified
     */
    public function get(string $key)
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $value = $app->data->getValue('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
        if ($value !== null) {
            try {
                $value = unserialize(gzuncompress($value));
                $constructCacheItem = function () use ($key, $value) {
                    $cacheItem = new CacheItem($key, $value[1]);
                    //$cacheItem->ttl = //todo
                    return $cacheItem;
                };
                if ($value[0] > 0) {
                    if ($value[0] > time()) {
                        return $constructCacheItem();
                    }
                    return null;
                }
                return $constructCacheItem();
            } catch (\Exception $e) {
                
            }
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
     * @return boolean TRUE if the key exists in the cache, FALSE otherwise.
     */
    public function exists(string $key)
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $value = $app->data->getValue('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
        if ($value !== null) {
            try {
                $value = unserialize(gzuncompress($value));
                if ($value[0] > 0) {
                    return $value[0] > time();
                }
                return true;
            } catch (\Exception $e) {
                
            }
        }
        return false;
    }

    /**
     * Deletes data from the cache
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function delete(string $key)
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $app->data->delete('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
    }

}
