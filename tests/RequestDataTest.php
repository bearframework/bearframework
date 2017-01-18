<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Request\DataItem;
use BearFramework\App\Request\DataRepository;

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
        $data = new DataRepository();
        $data->set(new DataItem('name1', 'value1'));
        $data->set(new DataItem('name2', 'value2'));
        $this->assertNull($data->get('missing'));
        $this->assertNull($data->getValue('missing'));
        $this->assertEquals($data->get('name1')->value, 'value1');
        $this->assertEquals($data->getValue('name1'), 'value1');
        $this->assertFalse($data->exists('missing'));
        $this->assertTrue($data->exists('name1'));
        $list = $data->getList();
        $this->assertEquals($list->length, 2);
        $this->assertEquals($list[0]->name, 'name1');
        $this->assertEquals($list[0]->value, 'value1');
        $this->assertEquals($list[1]->name, 'name2');
        $this->assertEquals($list[1]->value, 'value2');
        $data->delete('name1');
        $this->assertFalse($data->exists('name1'));
        $list = $data->getList();
        $this->assertEquals($list->length, 1);
    }

}
