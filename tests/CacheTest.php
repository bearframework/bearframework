<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * 
 */
class CacheTest extends BearFrameworkTestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAll()
    {
        $app = $this->getApp();

        $app->cache->delete('key1');

        $result = $app->cache->get('key1');
        $this->assertFalse($result);
        $result = $app->cache->exists('key1');
        $this->assertFalse($result);

        $app->cache->set('key1', 'data1');
        $result = $app->cache->get('key1');
        $this->assertTrue($result === 'data1');
        $result = $app->cache->exists('key1');
        $this->assertTrue($result === true);
        $app->cache->delete('key1');

        $result = $app->cache->get('key1');
        $this->assertFalse($result);
        $result = $app->cache->exists('key1');
        $this->assertFalse($result);
    }

    /**
     * @runInSeparateProcess
     */
    public function testTTL()
    {
        $app = $this->getApp();

        $app->cache->delete('key1');

        $app->cache->set('key1', 'data1', 2);
        $result = $app->cache->get('key1');
        $this->assertTrue($result === 'data1');
        $result = $app->cache->exists('key1');
        $this->assertTrue($result === true);
        sleep(3);
        $result = $app->cache->get('key1');
        $this->assertFalse($result);
        $result = $app->cache->exists('key1');
        $this->assertFalse($result);
        $app->cache->delete('key1');
    }

}
