<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

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

        $result = $app->cache->get('key1');
        $this->assertFalse($result);
        $this->assertFalse($app->cache->exists('key1'));

        $app->cache->set('key1', 'data1');
        $result = $app->cache->get('key1');
        $this->assertTrue($result === 'data1');
        $this->assertTrue($app->cache->exists('key1'));
        $app->cache->delete('key1');

        $result = $app->cache->get('key1');
        $this->assertFalse($result);
        $this->assertFalse($app->cache->exists('key1'));
    }

    /**
     * 
     */
    public function testTTL()
    {
        $app = $this->getApp();

        $app->cache->delete('key1');

        $app->cache->set('key1', 'data1', 2);
        $result = $app->cache->get('key1');
        $this->assertTrue($result === 'data1');
        sleep(3);
        $result = $app->cache->get('key1');
        $this->assertFalse($result);
        $app->cache->delete('key1');
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->cache->get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->cache->exists(1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->cache->set(1, 'data');
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->cache->set('key1', 1, 'wrong');
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->cache->delete(1);
    }

}
