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
class TempDataRepository
{

    /**
     * Saves temp data
     * 
     * @param string $key The data key
     * @param mixed $value The data
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function set(\BearFramework\App\TempDataItem $item): void
    {
        $app = App::get();
        $currentPeriodDataKey = $this->getPeriodDataKey($item->key, 0);
        if ($currentPeriodDataKey === null) {
            return;
        }
        $previousPeriodDataKey = $this->getPeriodDataKey($item->key, 1);
        $app->data->setValue($currentPeriodDataKey, gzcompress(serialize($item->value)));
        if ($app->data->exists($previousPeriodDataKey)) {
            $app->data->delete($previousPeriodDataKey);
        }
    }

    /**
     * Return the saved temp data or the default value specified
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @return mixed The saved temp data or the default value specified
     */
    public function get(string $key): ?\BearFramework\App\TempDataItem
    {
        $app = App::get();
        $currentPeriodDataKey = $this->getPeriodDataKey($key, 0);
        if ($currentPeriodDataKey === null) {
            return null;
        }
        $value = $app->data->getValue($currentPeriodDataKey);
        if ($value !== null) {
            return new TempDataItem($key, unserialize(gzuncompress($value)));
        }
        $previousPeriodDataKey = $this->getPeriodDataKey($key, 1);
        $value = $app->data->getValue($previousPeriodDataKey);
        if ($value !== null) {
            $app->data->setValue($currentPeriodDataKey, $value);
            return new TempDataItem($key, unserialize(gzuncompress($value)));
        }
        return null;
    }
    
    /**
     * 
     */
    public function getValue(string $key): ?string
    {
        $item = $this->get($key);
        if($item === null){
            return null;
        }
        return $item->value;
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
     * Returns the filename of the object key specified
     * 
     * @param string $key The data key
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\Config\InvalidOptionException
     * @return string The filename of the object key specified
     */
    public function getFilename(string $key): string
    {
        $app = App::get();
        $currentPeriodDataKey = $this->getPeriodDataKey($key, 0);
        return $app->data->getFilename($currentPeriodDataKey);
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
        $periodAge = floor($maxAge / 2);
        $keyMD5 = md5($key);
        return '.temp/tempdata/' . $maxAge . '/' . (floor(time() / $periodAge) * $periodAge - $periodIndex * $periodAge) . '/' . $keyMD5[0] . '/' . $keyMD5[1] . '/' . $keyMD5[3] . '/' . substr($keyMD5, 3);
    }

}
