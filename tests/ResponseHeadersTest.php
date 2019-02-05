<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Response\Header;
use BearFramework\App\Response\HeadersRepository;

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
        $headers = new HeadersRepository();
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
    }

}
