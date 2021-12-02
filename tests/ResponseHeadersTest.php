<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Response\Headers;

/**
 * @runTestsInSeparateProcesses
 */
class ResponseHeadersTest extends BearFrameworkTestCase
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

}
