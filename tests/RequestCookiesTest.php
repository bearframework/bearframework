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
class RequestCookiesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $query = new \BearFramework\App\Request\Cookies();
        $query->set('name1', 'value1');
        $query->set('name2', 'value2');
        $this->assertTrue($query->get('missing') === null);
        $this->assertTrue($query->get('name1') === 'value1');
        $this->assertTrue($query->exists('missing') === false);
        $this->assertTrue($query->exists('name1') === true);
        $list = $query->getList();
        $this->assertTrue($list[0]['name'] === 'name1');
        $this->assertTrue($list[0]['value'] === 'value1');
        $this->assertTrue($list[1]['name'] === 'name2');
        $this->assertTrue($list[1]['value'] === 'value2');
        $this->assertTrue(count($query) === 2);
        $query->delete('name1');
        $this->assertTrue(count($query) === 1);
        $this->assertTrue($query->exists('name1') === false);
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $query = new \BearFramework\App\Request\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $query->set(1, 1);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $query = new \BearFramework\App\Request\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $query->set('name1', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $query = new \BearFramework\App\Request\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $query->get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $query = new \BearFramework\App\Request\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $query->exists(1);
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $query = new \BearFramework\App\Request\Cookies();
        $this->setExpectedException('InvalidArgumentException');
        $query->delete(1);
    }

}
