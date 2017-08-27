<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
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
        $path = new \BearFramework\App\Request\PathRepository('/%D0%BF%D1%8A%D1%821/%D0%BF%D1%8A%D1%822/');
        $this->assertTrue((string) $path === '/%D0%BF%D1%8A%D1%821/%D0%BF%D1%8A%D1%822/');
        $this->assertTrue($path->get() === '/%D0%BF%D1%8A%D1%821/%D0%BF%D1%8A%D1%822/');
        $this->assertTrue($path->getSegment(0) === 'път1');
        $this->assertTrue($path->getSegment(0, false) === '%D0%BF%D1%8A%D1%821');
        $this->assertTrue($path->getSegment(1) === 'път2');
        $this->assertTrue($path->getSegment(1, false) === '%D0%BF%D1%8A%D1%822');
        $this->assertTrue($path->getSegment(2) === null);
    }

}
