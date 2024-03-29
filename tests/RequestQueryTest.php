<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Request\Query;

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
        $query = new Query();
        $query->set($query->make('name1', 'value1'));
        $query->set($query->make('name2', 'value2'));
        $this->assertNull($query->get('missing'));
        $this->assertNull($query->getValue('missing'));
        $this->assertEquals($query->get('name1')->value, 'value1');
        $this->assertEquals($query->getValue('name1'), 'value1');
        $this->assertFalse($query->exists('missing'));
        $this->assertTrue($query->exists('name1'));
        $list = $query->getList();
        $this->assertEquals($list->count(), 2);
        $this->assertEquals($list[0]->name, 'name1');
        $this->assertEquals($list[0]->value, 'value1');
        $this->assertEquals($list[1]->name, 'name2');
        $this->assertEquals($list[1]->value, 'value2');
        $query->delete('name1');
        $this->assertFalse($query->exists('name1'));
        $list = $query->getList();
        $this->assertEquals($list->count(), 1);

        $query = new Query();
        $query->set($query->make('name1', 'value1'));
        $query->set($query->make('name2', 'value2'));
        $query->deleteAll();
        $this->assertFalse($query->exists('name1'));
        $this->assertFalse($query->exists('name2'));
        $this->assertEquals($query->getList()->count(), 0);
    }
}
