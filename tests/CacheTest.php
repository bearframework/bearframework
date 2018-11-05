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

        $app->cache->addEventListener('itemChange', function(\BearFramework\App\Cache\ItemChangeEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['change', $event->key];
        });

        $app->cache->addEventListener('itemRequest', function(\BearFramework\App\Cache\ItemRequestEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['request', $event->key];
        });

        $app->cache->addEventListener('itemSet', function(\BearFramework\App\Cache\ItemSetEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['set', $event->item->key, $event->item->value];
        });

        $app->cache->addEventListener('itemGet', function(\BearFramework\App\Cache\ItemGetEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['get', $event->item->key, $event->item->value];
        });

        $app->cache->addEventListener('itemGetValue', function(\BearFramework\App\Cache\ItemGetValueEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['getValue', $event->key, $event->value];
        });

        $app->cache->addEventListener('itemExists', function(\BearFramework\App\Cache\ItemExistsEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['exists', $event->key, $event->exists];
        });

        $app->cache->addEventListener('itemDelete', function(\BearFramework\App\Cache\ItemDeleteEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['delete', $event->key];
        });

        $app->cache->addEventListener('clear', function(\BearFramework\App\Cache\ClearEvent $event) use (&$eventsLogs) {
            $eventsLogs[] = ['clear'];
        });

        $eventsLogs = [];
        $app->cache->set($app->cache->make('key1', 'data1'));
        $this->assertEquals($eventsLogs, [
            ['set', 'key1', 'data1'],
            ['change', 'key1']
        ]);

        $eventsLogs = [];
        $app->cache->get('key1');
        $this->assertEquals($eventsLogs, [
            ['get', 'key1', 'data1'],
            ['request', 'key1']
        ]);

        $eventsLogs = [];
        $app->cache->getValue('key1');
        $this->assertEquals($eventsLogs, [
            ['getValue', 'key1', 'data1'],
            ['request', 'key1']
        ]);

        $eventsLogs = [];
        $app->cache->exists('key1');
        $this->assertEquals($eventsLogs, [
            ['exists', 'key1', true],
            ['request', 'key1']
        ]);

        $eventsLogs = [];
        $app->cache->delete('key1');
        $this->assertEquals($eventsLogs, [
            ['delete', 'key1'],
            ['change', 'key1'],
        ]);

        $eventsLogs = [];
        $app->cache->clear();
        $this->assertEquals($eventsLogs, [
            ['clear']
        ]);
    }

}
