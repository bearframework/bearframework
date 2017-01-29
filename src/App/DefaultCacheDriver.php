<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

class DefaultCacheDriver implements \BearFramework\App\ICacheDriver
{

    public function set(string $key, $value, int $ttl = null): void
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $key = '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2';
        $app->data->setValue($key, gzcompress(serialize([$ttl > 0 ? time() + $ttl : 0, $value])));
    }

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

    public function delete(string $key): void
    {
        $app = App::get();
        $keyMD5 = md5($key);
        $app->data->delete('.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3) . '.2');
    }

    public function setMultiple(array $items, int $ttl = null): void
    {
        foreach ($items as $key => $value) {
            $this->set($key, $value, $ttl);
        }
    }

    public function getMultiple(array $keys): array
    {
        $results = [];
        foreach ($keys as $key) {
            $results[$key] = $this->get($key);
        }
        return $results;
    }

    public function deleteMultiple(array $keys): void
    {
        foreach ($keys as $key) {
            $this->delete($key);
        }
    }

}
