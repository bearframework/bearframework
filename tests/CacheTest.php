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
class CacheTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAll()
    {
        $app = new App([
            'dataDir' => sys_get_temp_dir() . '/unittests/data/'
        ]);

        $app->cache->delete('key1');

        $result = $app->cache->get('key1');
        $this->assertTrue($result === false);
        $result = $app->cache->exists('key1');
        $this->assertTrue($result === false);

        $app->cache->set('key1', 'data1');
        $result = $app->cache->get('key1');
        $this->assertTrue($result === 'data1');
        $result = $app->cache->exists('key1');
        $this->assertTrue($result === true);
        $app->cache->delete('key1');

        $result = $app->cache->get('key1');
        $this->assertTrue($result === false);
        $result = $app->cache->exists('key1');
        $this->assertTrue($result === false);
    }

    /**
     * @runInSeparateProcess
     */
    public function testTTL()
    {
        $app = new App([
            'dataDir' => sys_get_temp_dir() . '/unittests/data/'
        ]);

        $app->cache->delete('key1');

        $app->cache->set('key1', 'data1', 2);
        $result = $app->cache->get('key1');
        $this->assertTrue($result === 'data1');
        $result = $app->cache->exists('key1');
        $this->assertTrue($result === true);
        sleep(3);
        $result = $app->cache->get('key1');
        $this->assertTrue($result === false);
        $result = $app->cache->exists('key1');
        $this->assertTrue($result === false);
        $app->cache->delete('key1');
    }

}
