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
class RequestPathTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $path = new \BearFramework\App\Request\Path('/path1/path2/');
        $this->assertTrue((string) $path === '/path1/path2/');
        $this->assertTrue($path->get() === '/path1/path2/');
        $this->assertTrue(isset($path[0]));
        $this->assertTrue(isset($path[1]));
        $this->assertFalse(isset($path[2]));
        $this->assertTrue($path[0] === 'path1');
        $this->assertTrue($path[1] === 'path2');
        $this->assertTrue($path[2] === null);
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {

        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Request\Path(1);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $path = new \BearFramework\App\Request\Path();
        $this->setExpectedException('InvalidArgumentException');
        $path->set(1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $path = new \BearFramework\App\Request\Path('/path1/path2/');
        $this->setExpectedException('InvalidArgumentException');
        $a = $path['missing'];
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $path = new \BearFramework\App\Request\Path('/path1/path2/');
        $this->setExpectedException('InvalidArgumentException');
        isset($path['missing']);
    }

    /**
     * 
     */
    public function testExceptions1()
    {
        $path = new \BearFramework\App\Request\Path('/path1/path2/');
        $this->setExpectedException('Exception');
        unset($path[0]);
    }

    /**
     * 
     */
    public function testExceptions2()
    {
        $path = new \BearFramework\App\Request\Path('/path1/path2/');
        $this->setExpectedException('Exception');
        $path[0] = 'path1';
    }

}
