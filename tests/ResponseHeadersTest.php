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
class ResponseHeadersTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $headers = new \BearFramework\App\Response\Headers();
        $headers->set('Content-Type', 'application/x-www-form-urlencoded');
        $headers->set('Content-Length', '123');
        $this->assertTrue($headers->get('missing') === null);
        $this->assertTrue($headers->get('Content-Type') === 'application/x-www-form-urlencoded');
        $this->assertTrue($headers->exists('missing') === false);
        $this->assertTrue($headers->exists('Content-Type') === true);
        $list = $headers->getList();
        $this->assertTrue($list[0]['name'] === 'Content-Type');
        $this->assertTrue($list[0]['value'] === 'application/x-www-form-urlencoded');
        $this->assertTrue($list[1]['name'] === 'Content-Length');
        $this->assertTrue($list[1]['value'] === '123');
        $this->assertTrue(count($headers) === 2);
        $headers->delete('Content-Type');
        $this->assertTrue(count($headers) === 1);
        $this->assertTrue($headers->exists('Content-Type') === false);
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $headers = new \BearFramework\App\Response\Headers();
        $this->setExpectedException('InvalidArgumentException');
        $headers->set(1, 1);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $headers = new \BearFramework\App\Response\Headers();
        $this->setExpectedException('InvalidArgumentException');
        $headers->set('Content-Type', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $headers = new \BearFramework\App\Response\Headers();
        $this->setExpectedException('InvalidArgumentException');
        $headers->get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $headers = new \BearFramework\App\Response\Headers();
        $this->setExpectedException('InvalidArgumentException');
        $headers->exists(1);
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $headers = new \BearFramework\App\Response\Headers();
        $this->setExpectedException('InvalidArgumentException');
        $headers->delete(1);
    }

}
