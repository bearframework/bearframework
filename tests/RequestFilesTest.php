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
        $files = new \BearFramework\App\Request\Files();
        $files->set('name1', 'file1.jpg', '/tmp/file1.jpg', 123, 'image/jpeg');
        $files->set('name2', 'file2.jpg', '/tmp/file2.jpg', 123, 'image/jpeg');
        $this->assertTrue($files->get('missing') === null);
        $this->assertTrue($files->get('name1')['filename'] === 'file1.jpg');
        $this->assertTrue($files->exists('missing') === false);
        $this->assertTrue($files->exists('name1') === true);
        $list = $files->getList();
        $this->assertTrue($list[0]['name'] === 'name1');
        $this->assertTrue($list[0]['filename'] === 'file1.jpg');
        $this->assertTrue($list[1]['name'] === 'name2');
        $this->assertTrue($list[1]['filename'] === 'file2.jpg');
        $this->assertTrue(count($files) === 2);
        $files->delete('name1');
        $this->assertTrue(count($files) === 1);
        $this->assertTrue($files->exists('name1') === false);
    }

    /**
     * 
     */
    public function testInvalidArguments1a()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->set(1, 'file1.jpg', '/tmp/file1.jpg', 123);
    }

    /**
     * 
     */
    public function testInvalidArguments1b()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->set('name1', 1, '/tmp/file1.jpg', 123);
    }

    /**
     * 
     */
    public function testInvalidArguments1c()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->set('name1', 'file1.jpg', 1, 123);
    }

    /**
     * 
     */
    public function testInvalidArguments1d()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->set('name1', 'file1.jpg', '/tmp/file1.jpg', 'size');
    }

    /**
     * 
     */
    public function testInvalidArguments1e()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->set('name1', 'file1.jpg', '/tmp/file1.jpg', 123, 1);
    }

    /**
     * 
     */
    public function testInvalidArguments1f()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->set('name1', 'file1.jpg', '/tmp/file1.jpg', 123, 'image/jpeg', 'error');
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->exists(1);
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $files = new \BearFramework\App\Request\Files();
        $this->setExpectedException('InvalidArgumentException');
        $files->delete(1);
    }

}
