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
class ResponseCookiesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $cookies->set('name1', 'value1');
        $cookies->set('name2', 'value2');
        $this->assertTrue($cookies->get('missing') === null);
        $this->assertTrue($cookies->get('name1')['value'] === 'value1');
        $this->assertTrue($cookies->exists('missing') === false);
        $this->assertTrue($cookies->exists('name1') === true);
        $list = $cookies->getList();
        $this->assertTrue($list[0]['name'] === 'name1');
        $this->assertTrue($list[0]['value'] === 'value1');
        $this->assertTrue($list[1]['name'] === 'name2');
        $this->assertTrue($list[1]['value'] === 'value2');
        $this->assertTrue(count($cookies) === 2);
        $cookies->delete('name1');
        $this->assertTrue(count($cookies) === 1);
        $this->assertTrue($cookies->exists('name1') === false);
    }

    /**
     * 
     */
    public function testInvalidArguments1a()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->set(1, 1);
    }

    /**
     * 
     */
    public function testInvalidArguments1b()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->set('name1', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments1c()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->set('name1', 'value1', [
            'expire' => 'expire'
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments1d()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->set('name1', 'value1', [
            'path' => 1
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments1e()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->set('name1', 'value1', [
            'domain' => 1
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments1f()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->set('name1', 'value1', [
            'secure' => 1
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments1g()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->set('name1', 'value1', [
            'httpOnly' => 1
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->exists(1);
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $cookies = new \BearFramework\App\Response\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $cookies->delete(1);
    }

}
