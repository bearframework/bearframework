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

        $changeCount = 0;
        $app->cache->addEventListener('itemChange', function(\BearFramework\App\Cache\ItemChangeEvent $event) use (&$changeCount) {
            $this->assertEquals($event->key, 'key1');
            $changeCount++;
        });

        $requestCount = 0;
        $app->cache->addEventListener('itemRequest', function(\BearFramework\App\Cache\ItemRequestEvent $event) use (&$requestCount) {
            $this->assertEquals($event->key, 'key1');
            $requestCount++;
        });

        $setDone = false;
        $app->cache->addEventListener('itemSet', function(\BearFramework\App\Cache\ItemSetEvent $event) use (&$setDone) {
            $this->assertEquals($event->item->key, 'key1');
            $this->assertEquals($event->item->value, 'data1');
            $setDone = true;
        });

        $getDone = false;
        $app->cache->addEventListener('itemGet', function(\BearFramework\App\Cache\ItemGetEvent $event) use (&$getDone) {
            $this->assertEquals($event->item->key, 'key1');
            $this->assertEquals($event->item->value, 'data1');
            $getDone = true;
        });

        $getValueDone = false;
        $app->cache->addEventListener('itemGetValue', function(\BearFramework\App\Cache\ItemGetValueEvent $event) use (&$getValueDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->value, 'data1');
            $getValueDone = true;
        });

        $existsDone = false;
        $app->cache->addEventListener('itemExists', function(\BearFramework\App\Cache\ItemExistsEvent $event) use (&$existsDone) {
            $this->assertEquals($event->key, 'key1');
            $this->assertEquals($event->exists, true);
            $existsDone = true;
        });

        $deleteDone = false;
        $app->cache->addEventListener('itemDelete', function(\BearFramework\App\Cache\ItemDeleteEvent $event) use (&$deleteDone) {
            $this->assertEquals($event->key, 'key1');
            $deleteDone = true;
        });

        $clearDone = false;
        $app->cache->addEventListener('clear', function(\BearFramework\App\Cache\ClearEvent $event) use (&$clearDone) {
            $clearDone = true;
        });

        $cacheItem = $app->cache->make('key1', 'data1');
        $app->cache->set($cacheItem);
        $this->assertTrue($setDone);

        $app->cache->get('key1');
        $this->assertTrue($getDone);

        $app->cache->getValue('key1');
        $this->assertTrue($getValueDone);

        $app->cache->exists('key1');
        $this->assertTrue($existsDone);

        $app->cache->delete('key1');
        $this->assertTrue($deleteDone);

        $app->cache->clear();
        $this->assertTrue($clearDone);

        $this->assertEquals($changeCount, 2); // set + delete
        $this->assertEquals($requestCount, 3); // get + getValue + exists
    }

}
