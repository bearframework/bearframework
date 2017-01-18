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
        $path = new \BearFramework\App\Request\PathRepository('/path1/path2/');
        $this->assertTrue((string) $path === '/path1/path2/');
        $this->assertTrue($path->get() === '/path1/path2/');
        $this->assertTrue($path->getSegment(0) === 'path1');
        $this->assertTrue($path->getSegment(1) === 'path2');
        $this->assertTrue($path->getSegment(2) === null);
    }

}
