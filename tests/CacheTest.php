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
     * 
     */
    public function testEvents()
    {
        $app = $this->getApp();

        $eventsLogs = [];

        $app->cache->addEventListener('itemChange', function (\BearFramework\App\Cache\ItemChangeEventDetails $details) use (&$eventsLogs): void {
            $eventsLogs[] = ['change', $details->key, $details->action];
        });

        $app->cache->addEventListener('itemRequest', function (\BearFramework\App\Cache\ItemRequestEventDetails $details) use (&$eventsLogs): void {
            $eventsLogs[] = ['request', $details->key, $details->action];
        });

        $app->cache->addEventListener('itemSet', function (\BearFramework\App\Cache\ItemSetEventDetails $details) use (&$eventsLogs): void {
            $eventsLogs[] = ['set', $details->item->key, $details->item->value];
        });

        $app->cache->addEventListener('itemGet', function (\BearFramework\App\Cache\ItemGetEventDetails $details) use (&$eventsLogs): void {
            $eventsLogs[] = ['get', $details->item->key, $details->item->value];
        });

        $app->cache->addEventListener('itemGetValue', function (\BearFramework\App\Cache\ItemGetValueEventDetails $details) use (&$eventsLogs): void {
            $eventsLogs[] = ['getValue', $details->key, $details->value];
        });

        $app->cache->addEventListener('itemExists', function (\BearFramework\App\Cache\ItemExistsEventDetails $details) use (&$eventsLogs): void {
            $eventsLogs[] = ['exists', $details->key, $details->exists];
        });

        $app->cache->addEventListener('itemDelete', function (\BearFramework\App\Cache\ItemDeleteEventDetails $details) use (&$eventsLogs): void {
            $eventsLogs[] = ['delete', $details->key];
        });

        $app->cache->addEventListener('clear', function () use (&$eventsLogs): void {
            $eventsLogs[] = ['clear'];
        });

        $eventsLogs = [];
        $app->cache->set($app->cache->make('key1', 'data1'));
        $this->assertEquals($eventsLogs, [
            ['set', 'key1', 'data1'],
            ['change', 'key1', 'set']
        ]);

        $eventsLogs = [];
        $app->cache->get('key1');
        $this->assertEquals($eventsLogs, [
            ['get', 'key1', 'data1'],
            ['request', 'key1', 'get']
        ]);

        $eventsLogs = [];
        $app->cache->getValue('key1');
        $this->assertEquals($eventsLogs, [
            ['getValue', 'key1', 'data1'],
            ['request', 'key1', 'getValue']
        ]);

        $eventsLogs = [];
        $app->cache->exists('key1');
        $this->assertEquals($eventsLogs, [
            ['exists', 'key1', true],
            ['request', 'key1', 'exists']
        ]);

        $eventsLogs = [];
        $app->cache->delete('key1');
        $this->assertEquals($eventsLogs, [
            ['delete', 'key1'],
            ['change', 'key1', 'delete'],
        ]);

        $eventsLogs = [];
        $app->cache->clear();
        $this->assertEquals($eventsLogs, [
            ['clear']
        ]);
    }

    /**
     * 
     */
    public function testNullDriver()
    {
        $app = new \BearFramework\App();
        $app->cache->useNullDriver();
        $app->cache->set($app->cache->make('key1', 'value1'));
        $this->assertTrue(true);
    }
}
