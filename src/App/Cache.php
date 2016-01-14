<?php

namespace App;

class Cache
{

    /**
     * 
     * @param string $key
     * @param string $defaultValue
     * @return string|false
     * @throws \BearCMS\DataCache\NotFoundException
     */
    static function get($key, $defaultValue = false)
    {
        global $app;
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
                    return gzuncompress($data['body']);
                } else {
                    return $defaultValue;
                }
            } else {
                return gzuncompress($data['body']);
            }
        } else {
            return $defaultValue;
        }
    }

    /**
     * 
     * @param mixed $key
     * @return boolean
     */
    static function exists($key)
    {
        global $app;
        $keyMD5 = md5($key);
        $data = $app->data->get(
                [
                    'key' => '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3),
                    'result' => ['key', 'metadata.t']
                ]
        );
        if (isset($data)) {
            if (strlen($data['metadata.t']) > 0) {
                return (int) $data['metadata.t'] > time();
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @param mixed $key
     * @param mixed $value
     * @param int $time
     * @throws \InvalidArgumentException
     */
    static function set($key, $value, $time = 0)
    {
        global $app;
        $keyMD5 = md5($key);
        $data = [
            'key' => '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3),
            'body' => gzcompress($value)
        ];
        if ($time > 0) {
            $data['metadata.t'] = (string) (time() + $time);
        }
        $app->data->set($data);
    }

    /**
     * 
     * @param mixed $key
     * @throws \InvalidArgumentException
     */
    static function delete($key)
    {
        global $app;
        $keyMD5 = md5($key);
        $app->data->delete([
            'key' => '.temp/cache/' . substr($keyMD5, 0, 3) . '/' . substr($keyMD5, 3),
        ]);
    }

}
