<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

use BearFramework\App\Request\FormData;

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
        $formData = new FormData();
        $formData->set($formData->make('name1', 'value1'));
        $formData->set($formData->make('name2', 'value2'));
        $this->assertNull($formData->get('missing'));
        $this->assertNull($formData->getValue('missing'));
        $this->assertEquals($formData->get('name1')->value, 'value1');
        $this->assertEquals($formData->getValue('name1'), 'value1');
        $this->assertFalse($formData->exists('missing'));
        $this->assertTrue($formData->exists('name1'));
        $list = $formData->getList();
        $this->assertEquals($list->count(), 2);
        $this->assertEquals($list[0]->name, 'name1');
        $this->assertEquals($list[0]->value, 'value1');
        $this->assertEquals($list[1]->name, 'name2');
        $this->assertEquals($list[1]->value, 'value2');
        $formData->delete('name1');
        $this->assertFalse($formData->exists('name1'));
        $list = $formData->getList();
        $this->assertEquals($list->count(), 1);
    }

}
