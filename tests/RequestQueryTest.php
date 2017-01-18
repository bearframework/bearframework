<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Request\QueryItem;
use BearFramework\App\Request\QueryRepository;

/**
 * @runTestsInSeparateProcesses
 */
class RequestQueryTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $data = new QueryRepository();
        $data->set(new QueryItem('name1', 'value1'));
        $data->set(new QueryItem('name2', 'value2'));
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
