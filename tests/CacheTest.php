<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
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
     * 
     */
    public function testHooks()
    {
        $app = $this->getApp();

        $lastHookData = null;

        $app->hooks->add('cacheItemChanged', function(\BearFramework\App\Hooks\CacheItemChangedData $data) use (&$lastHookData) {
            $lastHookData = $data;
        });

        $app->hooks->add('cacheItemRequested', function(\BearFramework\App\Hooks\CacheItemRequestedData $data) use (&$lastHookData) {
            $lastHookData = $data;
        });

        $cacheItem = $app->cache->make('key1', 'data1');
        $app->cache->set($cacheItem);
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemChangedData);
        $this->assertTrue($lastHookData->action === 'set');
        $this->assertTrue($lastHookData->key === 'key1');

        $app->cache->exists('key1');
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemRequestedData);
        $this->assertTrue($lastHookData->action === 'exists');
        $this->assertTrue($lastHookData->key === 'key1');
        $this->assertTrue($lastHookData->exists === true);

        $app->cache->get('key1');
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemRequestedData);
        $this->assertTrue($lastHookData->action === 'get');
        $this->assertTrue($lastHookData->key === 'key1');
        $this->assertTrue($lastHookData->exists === true);

        $app->cache->getValue('key1');
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemRequestedData);
        $this->assertTrue($lastHookData->action === 'getValue');
        $this->assertTrue($lastHookData->key === 'key1');
        $this->assertTrue($lastHookData->exists === true);

        $app->cache->delete('key1');
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemChangedData);
        $this->assertTrue($lastHookData->action === 'delete');
        $this->assertTrue($lastHookData->key === 'key1');

        $app->cache->exists('key1');
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemRequestedData);
        $this->assertTrue($lastHookData->action === 'exists');
        $this->assertTrue($lastHookData->key === 'key1');
        $this->assertTrue($lastHookData->exists === false);

        $app->cache->get('key1');
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemRequestedData);
        $this->assertTrue($lastHookData->action === 'get');
        $this->assertTrue($lastHookData->key === 'key1');
        $this->assertTrue($lastHookData->exists === false);

        $app->cache->getValue('key1');
        $this->assertTrue($lastHookData instanceof \BearFramework\App\Hooks\CacheItemRequestedData);
        $this->assertTrue($lastHookData->action === 'getValue');
        $this->assertTrue($lastHookData->key === 'key1');
        $this->assertTrue($lastHookData->exists === false);
    }

}
