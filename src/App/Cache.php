<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Data cache
 */
class Cache
{

    /**
     * Return the saved data from the cache or the default value specified
     * 
     * @param string $key The data key
     * @param string $defaultValue The default value which will be returned if the data is missing from the cache
     * @throws \InvalidArgumentException
     * @return mixed The saved data from the cache or the default value specified
     */
    public function get($key, $defaultValue = null)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('The key argument must be of type string');
        }
        $app = App::get();
        $keyMD5 = md5($key);
        $data = $app->data->get('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
        if ($data !== null) {
            try {
                $body = unserialize(gzuncompress($data->body));
                if ($body[0] > 0) {
                    if ($body[0] > time()) {
                        return $body[1];
                    }
                    return $defaultValue;
                }
                return $body[1];
            } catch (\Exception $e) {
                
            }
        }
        return $defaultValue;
    }

    /**
     * Returns information whether a key exists in the cache.
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return boolean TRUE if the key exists in the cache, FALSE otherwise.
     */
    public function exists($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('The key argument must be of type string');
        }
        $app = App::get();
        $keyMD5 = md5($key);
        $data = $app->data->get('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
        if ($data !== null) {
            try {
                $body = unserialize(gzuncompress($data->body));
                if ($body[0] > 0) {
                    return $body[0] > time();
                }
                return true;
            } catch (\Exception $e) {
                
            }
        }
        return false;
    }

    /**
     * Saves data in the cache
     * 
     * @param string $key The data key
     * @param mixed $value The data
     * @param array $options List of options. Available values: ttl (time in seconds to stay in the cache)
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function set($key, $value, $options = [])
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('The key argument must be of type string');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('The options argument must be of type array');
        }
        if (isset($options['ttl']) && !is_int($options['ttl'])) {
            throw new \InvalidArgumentException('The ttl option must be of type int');
        }
        $ttl = isset($options['ttl']) ? $options['ttl'] : 0;
        $app = App::get();
        $keyMD5 = md5($key);
        $key = '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2';
        $app->data->set($key, gzcompress(serialize([$ttl > 0 ? time() + $ttl : 0, $value])));
    }

    /**
     * Deletes data from the cache
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function delete($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('The key argument must be of type string');
        }
        $app = App::get();
        $keyMD5 = md5($key);
        $app->data->delete('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
    }

}
