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
 * Temp data
 */
class TempData
{

    /**
     * Return the saved temp data or the default value specified
     * 
     * @param string $key The data key
     * @param string $defaultValue The default value which will be returned if the temp data is missing
     * @throws \InvalidArgumentException
     * @return mixed The saved temp data or the default value specified
     */
    public function get(string $key, $defaultValue = null)
    {
        $app = App::get();
        $currentPeriodDataKey = $this->getPeriodDataKey($key, 0);
        if ($currentPeriodDataKey === null) {
            return $defaultValue;
        }
        $result = $app->data->get($currentPeriodDataKey);
        if ($result !== null) {
            return unserialize(gzuncompress($result->body));
        }
        $previousPeriodDataKey = $this->getPeriodDataKey($key, 1);
        $result = $app->data->get($previousPeriodDataKey);
        if ($result !== null) {
            $app->data->set($currentPeriodDataKey, $result->body);
            return unserialize(gzuncompress($result->body));
        }
        return $defaultValue;
    }

    /**
     * Returns information whether a key exists in the temp data storage
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return boolean TRUE if the key exists in the temp data storage, FALSE otherwise.
     */
    public function exists(string $key): bool
    {
        $app = App::get();
        $currentPeriodDataKey = $this->getPeriodDataKey($key, 0);
        if ($currentPeriodDataKey === null) {
            return false;
        }
        if ($app->data->exists($currentPeriodDataKey)) {
            return true;
        }
        $previousPeriodDataKey = $this->getPeriodDataKey($key, 1);
        if ($app->data->exists($previousPeriodDataKey)) {
            $app->data->duplicate($previousPeriodDataKey, $currentPeriodDataKey);
            return true;
        }
        return false;
    }

    /**
     * Saves temp data
     * 
     * @param string $key The data key
     * @param mixed $value The data
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function set(string $key, $value)
    {
        $app = App::get();
        $currentPeriodDataKey = $this->getPeriodDataKey($key, 0);
        if ($currentPeriodDataKey === null) {
            return;
        }
        $previousPeriodDataKey = $this->getPeriodDataKey($key, 1);
        $app->data->set($currentPeriodDataKey, gzcompress(serialize($value)));
        if ($app->data->exists($previousPeriodDataKey)) {
            $app->data->delete($previousPeriodDataKey);
        }
    }

    /**
     * Deletes temp data
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function delete(string $key)
    {
        $app = App::get();
        $currentPeriodDataKey = $this->getPeriodDataKey($key, 0);
        if ($currentPeriodDataKey === null) {
            return;
        }
        $previousPeriodDataKey = $this->getPeriodDataKey($key, 1);
        $app->data->delete($currentPeriodDataKey);
        $app->data->delete($previousPeriodDataKey);
    }

    /**
     * 
     * @param string $key
     * @param int $periodIndex
     * @return string
     */
    private function getPeriodDataKey(string $key, int $periodIndex): ?string
    {
        $app = App::get();
        $maxAge = (int) $app->config->tempDataMaxAge;
        if ($maxAge === 0) {
            return null;
        }
        $periodAge = $maxAge / 2;
        $keyMD5 = md5($key);
        return '.temp/tempdata/' . $maxAge . '/' . (floor(time() / $periodAge) * $periodAge - $periodIndex * $periodAge) . '/' . $keyMD5[0] . '/' . $keyMD5[1] . '/' . $keyMD5[3] . '/' . substr($keyMD5, 3);
    }

}
