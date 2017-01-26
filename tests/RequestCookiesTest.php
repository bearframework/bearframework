<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Request\Cookie;
use BearFramework\App\Request\CookiesRepository;

/**
 * @runTestsInSeparateProcesses
 */
class RequestCookiesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $cookies = new CookiesRepository();
        $cookies->set($cookies->make('name1', 'value1'));
        $cookies->set($cookies->make('name2', 'value2'));
        $this->assertNull($cookies->get('missing'));
        $this->assertNull($cookies->getValue('missing'));
        $this->assertEquals($cookies->get('name1')->value, 'value1');
        $this->assertEquals($cookies->getValue('name1'), 'value1');
        $this->assertFalse($cookies->exists('missing'));
        $this->assertTrue($cookies->exists('name1'));
        $list = $cookies->getList();
        $this->assertEquals($list->length, 2);
        $this->assertEquals($list[0]->name, 'name1');
        $this->assertEquals($list[0]->value, 'value1');
        $this->assertEquals($list[1]->name, 'name2');
        $this->assertEquals($list[1]->value, 'value2');
        $cookies->delete('name1');
        $this->assertFalse($cookies->exists('name1'));
        $list = $cookies->getList();
        $this->assertEquals($list->length, 1);
    }

}
