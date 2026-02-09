<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Request\Headers;

/**
 * @runTestsInSeparateProcesses
 */
class RequestHeadersTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $headers = new Headers();
        $headers->set($headers->make('Content-Type', 'application/x-www-form-urlencoded'));
        $headers->set($headers->make('Content-Length', '123'));
        $this->assertNull($headers->get('missing'));
        $this->assertNull($headers->getValue('missing'));
        $this->assertEquals($headers->get('Content-Type')->value, 'application/x-www-form-urlencoded');
        $this->assertEquals($headers->getValue('Content-Type'), 'application/x-www-form-urlencoded');
        $this->assertFalse($headers->exists('missing'));
        $this->assertTrue($headers->exists('Content-Type'));
        $list = $headers->getList();
        $this->assertEquals($list->count(), 2);
        $this->assertEquals($list[0]->name, 'Content-Type');
        $this->assertEquals($list[0]->value, 'application/x-www-form-urlencoded');
        $this->assertEquals($list[1]->name, 'Content-Length');
        $this->assertEquals($list[1]->value, '123');
        $headers->delete('Content-Type');
        $this->assertFalse($headers->exists('Content-Type'));
        $list = $headers->getList();
        $this->assertEquals($list->count(), 1);

        $headers = new Headers();
        $headers->set($headers->make('name1', 'value1'));
        $headers->set($headers->make('name2', 'value2'));
        $headers->deleteAll();
        $this->assertFalse($headers->exists('name1'));
        $this->assertFalse($headers->exists('name2'));
        $this->assertEquals($headers->getList()->count(), 0);
    }

    /**
     * 
     * @return void
     */
    function testCaseSensitivity()
    {
        $headers = new Headers();
        $headers->set($headers->make('Name1', 'Value1'));
        $this->assertEquals($headers->get('Name1')->value, 'Value1');
        $this->assertEquals($headers->get('name1')->value, 'Value1');
        $this->assertEquals($headers->getValue('Name1'), 'Value1');
        $this->assertEquals($headers->getValue('name1'), 'Value1');
        $this->assertTrue($headers->exists('Name1'));
        $this->assertTrue($headers->exists('name1'));
        $headers->delete('name1');
        $this->assertFalse($headers->exists('name1'));
    }
}
