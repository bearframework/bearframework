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
class TempDataTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAll()
    {
        $app = $this->getApp();

        $app->tempData->delete('key1');

        $result = $app->tempData->get('key1');
        $this->assertTrue($result === null);
        $this->assertFalse($app->tempData->exists('key1'));

        $app->tempData->set('key1', 'data1');
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === 'data1');
        $this->assertTrue($app->tempData->exists('key1'));
        $app->tempData->delete('key1');

        $result = $app->tempData->get('key1');
        $this->assertTrue($result === null);
        $this->assertFalse($app->tempData->exists('key1'));
    }

    /**
     * 
     */
    public function testDelayedGet()
    {
        $app = $this->getApp(['tempDataMaxAge' => 10]);

        $app->tempData->set('key1', 'data1');
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === 'data1');
        sleep(7);
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === 'data1');
        sleep(12);
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === null);
    }

    /**
     * 
     */
    public function testDelayedExists()
    {
        $app = $this->getApp(['tempDataMaxAge' => 10]);

        $app->tempData->set('key1', 'data1');
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === 'data1');
        sleep(7);
        $this->assertTrue($app->tempData->exists('key1'));
        sleep(12);
        $this->assertFalse($app->tempData->exists('key1'));
    }

    /**
     * 
     */
    public function testDelayedSet()
    {
        $app = $this->getApp(['tempDataMaxAge' => 10]);

        $app->tempData->set('key1', 'data1');
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === 'data1');
        sleep(7);
        $app->tempData->set('key1', 'data2');
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === 'data2');
        sleep(12);
        $app->tempData->set('key1', 'data3');
        $result = $app->tempData->get('key1');
        $this->assertTrue($result === 'data3');
    }

    /**
     * 
     */
    public function testInvalidConfig()
    {
        $app = $this->getApp(['tempDataMaxAge' => 0]);

        $app->tempData->set('key1', 'data1');
        $this->assertTrue($app->tempData->get('key1') === null);
        $this->assertFalse($app->tempData->exists('key1'));
        $app->tempData->delete('key1');
        $this->assertTrue($app->tempData->get('key1') === null);
    }

}
