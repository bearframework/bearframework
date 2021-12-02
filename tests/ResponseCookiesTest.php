<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Response\Cookies;

/**
 * @runTestsInSeparateProcesses
 */
class ResponseCookiesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $cookies = new Cookies();
        $cookie = $cookies->make('name1', 'value1');
        $cookies->set($cookie);
        $cookie = $cookies->make('name2', 'value2');
        $cookie2expireTime = time() + 5;
        $cookie->expire = $cookie2expireTime;
        $cookie->path = '/path/';
        $cookie->domain = 'example.com';
        $cookie->secure = true;
        $cookie->httpOnly = true;
        $cookies->set($cookie);
        $this->assertNull($cookies->get('missing'));
        $this->assertEquals($cookies->get('name1')->value, 'value1');
        $this->assertFalse($cookies->exists('missing'));
        $this->assertTrue($cookies->exists('name1'));
        $list = $cookies->getList();
        $this->assertEquals($list->count(), 2);
        $this->assertEquals($list[0]->name, 'name1');
        $this->assertEquals($list[0]->value, 'value1');
        $this->assertEquals($list[1]->name, 'name2');
        $this->assertEquals($list[1]->value, 'value2');
        $cookies->delete('name1');
        $this->assertFalse($cookies->exists('name1'));
        $list = $cookies->getList();
        $this->assertEquals($list->count(), 1);

        $cookie = $cookies->get('name2');
        $this->assertEquals($cookie->name, 'name2');
        $this->assertEquals($cookie->value, 'value2');
        $this->assertEquals($cookie->expire, $cookie2expireTime);
        $this->assertEquals($cookie->path, '/path/');
        $this->assertEquals($cookie->domain, 'example.com');
        $this->assertEquals($cookie->secure, true);
        $this->assertEquals($cookie->httpOnly, true);

        $cookies = new Cookies();
        $cookies->set($cookies->make('name1', 'value1'));
        $cookies->set($cookies->make('name2', 'value2'));
        $cookies->deleteAll();
        $this->assertFalse($cookies->exists('name1'));
        $this->assertFalse($cookies->exists('name2'));
        $this->assertEquals($cookies->getList()->count(), 0);
    }
}
