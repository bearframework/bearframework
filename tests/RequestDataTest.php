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
class RequestDataTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $data = new \BearFramework\App\Request\Data();
        $data->set('name1', 'value1');
        $data->set('name2', 'value2');
        $this->assertTrue($data->get('missing') === null);
        $this->assertTrue($data->get('name1') === 'value1');
        $this->assertTrue($data->exists('missing') === false);
        $this->assertTrue($data->exists('name1') === true);
        $list = $data->getList();
        $this->assertTrue($list[0]['name'] === 'name1');
        $this->assertTrue($list[0]['value'] === 'value1');
        $this->assertTrue($list[1]['name'] === 'name2');
        $this->assertTrue($list[1]['value'] === 'value2');
        $this->assertTrue(count($data) === 2);
        $data->delete('name1');
        $this->assertTrue(count($data) === 1);
        $this->assertTrue($data->exists('name1') === false);
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $data = new \BearFramework\App\Request\Data();
        $this->setExpectedException('InvalidArgumentException');
        $data->set(1, 1);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $data = new \BearFramework\App\Request\Data();
        $this->setExpectedException('InvalidArgumentException');
        $data->get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $data = new \BearFramework\App\Request\Data();
        $this->setExpectedException('InvalidArgumentException');
        $data->exists(1);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $data = new \BearFramework\App\Request\Data();
        $this->setExpectedException('InvalidArgumentException');
        $data->delete(1);
    }

}
