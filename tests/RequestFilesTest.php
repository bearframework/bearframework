<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class RequestFilesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $formData = new \BearFramework\App\Request\FormData();
        $file = new \BearFramework\App\Request\FormDataFileItem();
        $file->name = 'name1';
        $file->value = 'file1.jpg';
        $file->filename = '/tmp/file1.jpg';
        $file->size = 123;
        $file->type = 'image/jpeg';
        $formData->set($file);
        $file = new \BearFramework\App\Request\FormDataFileItem();
        $file->name = 'name2';
        $file->value = 'file2.jpg';
        $file->filename = '/tmp/file2.jpg';
        $file->size = 123;
        $file->type = 'image/jpeg';
        $formData->set($file);
        $this->assertTrue($formData->getFile('missing') === null);
        $this->assertTrue($formData->getFile('name1')->value === 'file1.jpg');
        $this->assertTrue($formData->exists('missing') === false);
        $this->assertTrue($formData->exists('name1') === true);
        $list = $formData->getList();
        $this->assertTrue($list->count() === 2);
        $this->assertTrue($list[0]->name === 'name1');
        $this->assertTrue($list[0]->value === 'file1.jpg');
        $this->assertTrue($list[0]->filename === '/tmp/file1.jpg');
        $this->assertTrue($list[1]->name === 'name2');
        $this->assertTrue($list[1]->value === 'file2.jpg');
        $this->assertTrue($list[1]->filename === '/tmp/file2.jpg');
        $formData->delete('name1');
        $list = $formData->getList();
        $this->assertTrue($list->count() === 1);
        $this->assertTrue($formData->exists('name1') === false);
    }

}
