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
     * Return the saved data from the cache of the default value specified
     * @param string $key The data key
     * @param string $defaultValue The default value which will be returned if the data is missing from the cache
     * @throws \BearCMS\DataCache\NotFoundException
     * @return mixed The saved data from the cache of the default value specified
     */
    public function get($key, $defaultValue = false)
    {
        $app = &App::$instance;
        $keyMD5 = md5($key);
        $data = $app->data->get(
                [
                    'key' => '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3),
                    'result' => ['body', 'metadata.t']
                ]
        );
        if (isset($data['body'])) {
            if (strlen($data['metadata.t']) > 0) {
                if ((int) $data['metadata.t'] > time()) {
                    return unserialize(gzuncompress($data['body']));
                }
                return $defaultValue;
            }
            return unserialize(gzuncompress($data['body']));
        }
        return $defaultValue;
    }

    /**
     * Saves data in the cache
     * @param mixed $key The data key
     * @param mixed $value The data
     * @param int $ttl Time in seconds to stay in the cache. Zero mean no expiration.
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function set($key, $value, $ttl = 0)
    {
        $app = &App::$instance;
        $keyMD5 = md5($key);
        $data = [
            'key' => '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3),
            'body' => gzcompress(serialize($value))
        ];
        if ($ttl > 0) {
            $data['metadata.t'] = (string) (time() + $ttl);
        }
        $app->data->set($data);
    }

    /**
     * Deletes data fom the cache
     * @param mixed $key The data key
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function delete($key)
    {
        $app = &App::$instance;
        $keyMD5 = md5($key);
        $app->data->delete([
            'key' => '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3),
        ]);
    }

}
