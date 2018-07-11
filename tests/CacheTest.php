<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\CacheItem;

/**
 * @runTestsInSeparateProcesses
 */
class CacheTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAll()
    {
        $app = $this->getApp();

        $app->cache->delete('key1');

        $result = $app->cache->getValue('key1');
        $this->assertTrue($result === null);
        $this->assertFalse($app->cache->exists('key1'));

        $app->cache->set($app->cache->make('key1', 'data1'));
        $result = $app->cache->getValue('key1');
        $this->assertTrue($result === 'data1');
        $this->assertTrue($app->cache->exists('key1'));
        $app->cache->delete('key1');

        $result = $app->cache->getValue('key1');
        $this->assertTrue($result === null);
        $this->assertFalse($app->cache->exists('key1'));
    }

    /**
     * 
     */
    public function testTTL()
    {
        $app = $this->getApp();

        $app->cache->delete('key1');

        $cacheItem = $app->cache->make('key1', 'data1');
        $cacheItem->ttl = 2;
        $app->cache->set($cacheItem);
        $result = $app->cache->getValue('key1');
        $this->assertTrue($result === 'data1');
        $result = $app->cache->exists('key1');
        $this->assertTrue($result);
        sleep(3);
        $result = $app->cache->getValue('key1');
        $this->assertTrue($result === null);
        $result = $app->cache->exists('key1');
        $this->assertFalse($result);
        $app->cache->delete('key1');
    }

    /**
     * 
     */
    public function testClear()
    {
        $app = $this->getApp();

        $app->cache->set($app->cache->make('key1', 'data1'));
        $app->cache->set($app->cache->make('key2', 'data2'));

        $this->assertTrue($app->cache->get('key1') !== null);
        $this->assertTrue($app->cache->get('key2') !== null);

        $app->cache->clear();

        $this->assertTrue($app->cache->get('key1') === null);
        $this->assertTrue($app->cache->get('key2') === null);
    }

    /**
     * Modify value
     */
    public function testHooks1()
    {
        $app = $this->getApp();

        $app->hooks->add('cacheItemSet', function(CacheItem $item) {
            $item->value = 'data2';
        });

        $cacheItem = $app->cache->make('key1', 'data1');
        $app->cache->set($cacheItem);
        $cacheItem = $app->cache->get('key1');
        $this->assertTrue($cacheItem->key === 'key1');
        $this->assertTrue($cacheItem->value === 'data2');
    }

    /**
     * Prevent defaults
     */
    public function testHooks2()
    {
        $app = $this->getApp();

        $cache = [];

        $app->hooks->add('cacheItemSet', function(CacheItem $item, &$preventDefault) use (&$cache) {
            $preventDefault = true;
            $cache[$item->key] = clone($item);
        });

        $app->hooks->add('cacheItemGet', function(string $key, &$returnValue, &$preventDefault) use (&$cache) {
            $preventDefault = true;
            if (isset($cache[$key])) {
                $returnValue = clone($cache[$key]);
            }
        });

        $app->hooks->add('cacheItemGetValue', function(string $key, &$returnValue, &$preventDefault) use (&$cache) {
            $preventDefault = true;
            if (isset($cache[$key])) {
                $returnValue = $cache[$key]->value;
            }
        });

        $app->hooks->add('cacheItemExists', function(string $key, &$returnValue) use (&$cache) {
            $returnValue = isset($cache[$key]);
        });

        $cacheItem = $app->cache->make('key1', 'data1');
        $app->cache->set($cacheItem);
        $cacheItem = $app->cache->get('key1');
        $this->assertTrue($cacheItem->key === 'key1');
        $this->assertTrue($cacheItem->value === 'data1');
        $this->assertTrue($app->cache->getValue('key1') === 'data1');
        $this->assertTrue($app->cache->getValue('key2') === null);
        $this->assertTrue($app->cache->exists('key1') === true);
        $this->assertTrue($app->cache->exists('key2') === false);
    }

}
