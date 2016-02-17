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
class RequestTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function testRequest()
    {
        $request = new \BearFramework\App\Request();
        $request->base = 'http://example.com';
        $request->path = new \BearFramework\App\Request\Path('/part1/part2/');
        $this->assertTrue((string) $request === 'http://example.com/part1/part2/');
    }

    /**
     * 
     */
    function testProperties()
    {
        $request = new \BearFramework\App\Request();
        $request->base = 'http://example.com';
        $request->path = new \BearFramework\App\Request\Path('/part1/part2/');
        $this->assertTrue(isset($request->method));
        $this->assertTrue(isset($request->scheme));
        $this->assertTrue(isset($request->host));
        $this->assertTrue(isset($request->base));
        $this->assertFalse(isset($request->missing));
    }

    /**
     * 
     */
    function testPath()
    {
        $request = new \BearFramework\App\Request();

        $request->path = new \BearFramework\App\Request\Path('/part1/part2/');
        $this->assertTrue((string) $request->path === '/part1/part2/');
        $this->assertTrue(isset($request->path[0]));
        $this->assertTrue(isset($request->path[1]));
        $this->assertFalse(isset($request->path[2]));
        $this->assertTrue($request->path[0] === 'part1');
        $this->assertTrue($request->path[1] === 'part2');
        $this->assertTrue($request->path[2] === null);

        $request->path = new \BearFramework\App\Request\Path('part1/part2');
        $this->assertTrue(isset($request->path[0]));
        $this->assertTrue(isset($request->path[1]));
        $this->assertFalse(isset($request->path[2]));
        $this->assertTrue($request->path[0] === 'part1');
        $this->assertTrue($request->path[1] === 'part2');
        $this->assertTrue($request->path[2] === null);

        $request->path = new \BearFramework\App\Request\Path('');
        $this->assertFalse(isset($request->path[0]));
        $this->assertTrue($request->path[0] === null);

        $request->path = new \BearFramework\App\Request\Path('/');
        $this->assertFalse(isset($request->path[0]));
        $this->assertTrue($request->path[0] === null);
    }

    /**
     * 
     */
    function testPathInvalidArguments1()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->path = new \BearFramework\App\Request\Path(1);
    }

    /**
     * 
     */
    function testPathInvalidArguments2()
    {
        $request = new \BearFramework\App\Request();
        $request->path = new \BearFramework\App\Request\Path('/part1/part2/');

        $this->setExpectedException('InvalidArgumentException');
        isset($request->path['test']);
    }

    /**
     * 
     */
    function testPathInvalidArguments3()
    {
        $request = new \BearFramework\App\Request();
        $request->path = new \BearFramework\App\Request\Path('/part1/part2/');

        $this->setExpectedException('InvalidArgumentException');
        echo $request->path['test'];
    }

    /**
     * 
     */
    function testPathNotImplementedsMethod1()
    {
        $request = new \BearFramework\App\Request();
        $request->path = new \BearFramework\App\Request\Path('/part1/part2/');

        $this->setExpectedException('Exception');
        $request->path['test'] = '1';
    }

    /**
     * 
     */
    function testPathNotImplementedsMethod2()
    {
        $request = new \BearFramework\App\Request();
        $request->path = new \BearFramework\App\Request\Path('/part1/part2/');

        $this->setExpectedException('Exception');
        unset($request->path['test']);
    }

    /**
     * 
     */
    function testQuery()
    {
        $request = new \BearFramework\App\Request();

        $request->query = new \BearFramework\App\Request\Query('var1=1&var2=a');
        $this->assertTrue((string) $request->query === 'var1=1&var2=a');
        $this->assertTrue(isset($request->query['var1']));
        $this->assertTrue(isset($request->query['var2']));
        $this->assertFalse(isset($request->query['var3']));
        $this->assertTrue($request->query['var1'] === '1');
        $this->assertTrue($request->query['var2'] === 'a');
        $this->assertTrue($request->query['var3'] === null);

        $request->query = new \BearFramework\App\Request\Query('');
        $this->assertFalse(isset($request->query['var1']));
        $this->assertTrue($request->query['var1'] === null);
    }

    /**
     * 
     */
    function testQueryInvalidArguments1()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->query = new \BearFramework\App\Request\Query(1);
    }

    /**
     * 
     */
    function testQueryInvalidArguments2()
    {
        $request = new \BearFramework\App\Request();
        $request->query = new \BearFramework\App\Request\Query('var1=1&var2=a');

        $this->setExpectedException('InvalidArgumentException');
        isset($request->query[1]);
    }

    /**
     * 
     */
    function testQueryInvalidArguments3()
    {
        $request = new \BearFramework\App\Request();
        $request->query = new \BearFramework\App\Request\Query('var1=1&var2=a');

        $this->setExpectedException('InvalidArgumentException');
        echo $request->query[1];
    }

    /**
     * 
     */
    function testQueryNotImplementedsMethod1()
    {
        $request = new \BearFramework\App\Request();
        $request->query = new \BearFramework\App\Request\Query('var1=1&var2=a');

        $this->setExpectedException('Exception');
        $request->query['test'] = '1';
    }

    /**
     * 
     */
    function testQueryNotImplementedsMethod2()
    {
        $request = new \BearFramework\App\Request();
        $request->query = new \BearFramework\App\Request\Query('var1=1&var2=a');

        $this->setExpectedException('Exception');
        unset($request->query['test']);
    }

    /**
     * 
     */
    function testInvalidGet()
    {
        $request = new \BearFramework\App\Request();
        $this->setExpectedException('Exception');
        echo $request->missing;
    }

}
