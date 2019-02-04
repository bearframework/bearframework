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
class RequestPathTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function test()
    {
        $path = new \BearFramework\App\Request\PathRepository('/path1/path2/');
        $this->assertTrue((string) $path === '/path1/path2/');
        $this->assertTrue($path->get() === '/path1/path2/');
        $this->assertTrue($path->getSegment(0) === 'path1');
        $this->assertTrue($path->getSegment(1) === 'path2');
        $this->assertTrue($path->getSegment(2) === null);
    }

    /**
     * 
     */
    function testSpecialChars()
    {
        $path = new \BearFramework\App\Request\PathRepository('/път1/път2/');
        $this->assertTrue((string) $path === '/път1/път2/');
        $this->assertTrue($path->get() === '/път1/път2/');
        $this->assertTrue($path->getSegment(0) === 'път1');
        $this->assertTrue($path->getSegment(1) === 'път2');
        $this->assertTrue($path->getSegment(2) === null);
    }

}
