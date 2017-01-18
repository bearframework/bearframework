<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

use \BearFramework\App\TempDataItem;

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

        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === null);
        $this->assertFalse($app->tempData->exists('key1'));

        $app->tempData->set(new TempDataItem('key1', 'data1'));
        $result = $app->tempData->get('key1')->value;
        $this->assertTrue($result === 'data1');
        $this->assertTrue($app->tempData->exists('key1'));
        $app->tempData->delete('key1');

        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === null);
        $this->assertFalse($app->tempData->exists('key1'));
    }

    /**
     * 
     */
    public function testDelayedGet()
    {
        $app = $this->getApp(['tempDataMaxAge' => 4]);

        $app->tempData->set(new TempDataItem('key1', 'data1'));
        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === 'data1');
        sleep(2);
        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === 'data1');
        sleep(5);
        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === null);
    }

    /**
     * 
     */
    public function testDelayedExists()
    {
        $app = $this->getApp(['tempDataMaxAge' => 4]);

        $app->tempData->set(new TempDataItem('key1', 'data1'));
        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === 'data1');
        sleep(2);
        $this->assertTrue($app->tempData->exists('key1'));
        sleep(5);
        $this->assertFalse($app->tempData->exists('key1'));
    }

    /**
     * 
     */
    public function testDelayedSet()
    {
        $app = $this->getApp(['tempDataMaxAge' => 4]);

        $app->tempData->set(new TempDataItem('key1', 'data1'));
        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === 'data1');
        sleep(2);
        $app->tempData->set(new TempDataItem('key1', 'data2'));
        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === 'data2');
        sleep(5);
        $app->tempData->set(new TempDataItem('key1', 'data3'));
        $result = $app->tempData->getValue('key1');
        $this->assertTrue($result === 'data3');
    }

    /**
     * 
     */
    public function testInvalidConfig()
    {
        $app = $this->getApp(['tempDataMaxAge' => 0]);

        $app->tempData->set(new TempDataItem('key1', 'data1'));
        $this->assertTrue($app->tempData->getValue('key1') === null);
        $this->assertFalse($app->tempData->exists('key1'));
        $app->tempData->delete('key1');
        $this->assertTrue($app->tempData->getValue('key1') === null);
    }

}
