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
class RequestFilesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $files = new \BearFramework\App\Request\FilesRepository();
        $file = new \BearFramework\App\Request\File('name1', '/tmp/file1.jpg');
        $file->filename = 'file1.jpg';
        $file->size = 123;
        $file->type = 'image/jpeg';
        $files->set($file);
        $file = new \BearFramework\App\Request\File('name2', '/tmp/file2.jpg');
        $file->filename = 'file2.jpg';
        $file->size = 123;
        $file->type = 'image/jpeg';
        $files->set($file);
        $this->assertTrue($files->get('missing') === null);
        $this->assertTrue($files->get('name1')->filename === 'file1.jpg');
        $this->assertTrue($files->exists('missing') === false);
        $this->assertTrue($files->exists('name1') === true);
        $list = $files->getList();
        $this->assertTrue($list->length === 2);
        $this->assertTrue($list[0]->name === 'name1');
        $this->assertTrue($list[0]->filename === 'file1.jpg');
        $this->assertTrue($list[1]->name === 'name2');
        $this->assertTrue($list[1]->filename === 'file2.jpg');
        $files->delete('name1');
        $list = $files->getList();
        $this->assertTrue($list->length === 1);
        $this->assertTrue($files->exists('name1') === false);
    }

}
