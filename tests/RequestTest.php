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
        $request->path->set('/part1/part2/');
        $this->assertTrue((string) $request === 'http://example.com/part1/part2/');
    }

    /**
     * 
     */
    function testProperties()
    {
        $request = new \BearFramework\App\Request();
        $request->base = 'http://example.com';
        $request->path->set('/part1/part2/');
        $this->assertTrue(isset($request->method));
        $this->assertTrue(isset($request->scheme));
        $this->assertTrue(isset($request->host));
        $this->assertTrue(isset($request->port));
        $this->assertTrue(isset($request->base));
        $this->assertTrue(isset($request->path));
        $this->assertTrue(isset($request->query));
        $this->assertTrue(isset($request->headers));
        $this->assertTrue(isset($request->cookies));
        $this->assertTrue(isset($request->data));
        $this->assertTrue(isset($request->files));
        $this->assertFalse(isset($request->missing));
    }

    /**
     * 
     */
    function testBase()
    {
        $request = new \BearFramework\App\Request();
        $request->base = 'http://example.com';
        $this->assertTrue($request->scheme === 'http');
        $this->assertTrue($request->host === 'example.com');
        $this->assertTrue($request->port === null);
        $request->scheme = 'https';
        $this->assertTrue($request->scheme === 'https');
        $this->assertTrue($request->host === 'example.com');
        $this->assertTrue($request->port === null);
        $request->host = 'new.com';
        $this->assertTrue($request->scheme === 'https');
        $this->assertTrue($request->host === 'new.com');
        $this->assertTrue($request->port === null);
        $request->host = 'subdomain.example.com';
        $this->assertTrue($request->scheme === 'https');
        $this->assertTrue($request->host === 'subdomain.example.com');
        $this->assertTrue($request->port === null);
        $request->port = 8888;
        $this->assertTrue($request->scheme === 'https');
        $this->assertTrue($request->host === 'subdomain.example.com');
        $this->assertTrue($request->port === 8888);
        $request->port = '9999';
        $this->assertTrue($request->scheme === 'https');
        $this->assertTrue($request->host === 'subdomain.example.com');
        $this->assertTrue($request->port === 9999);

        $this->assertTrue($request->base === 'https://subdomain.example.com:9999');

        $request->port = '';
        $this->assertTrue($request->scheme === 'https');
        $this->assertTrue($request->host === 'subdomain.example.com');
        $this->assertTrue($request->port === null);

        $this->assertTrue($request->base === 'https://subdomain.example.com');
    }

    /**
     * 
     */
    function testPath()
    {
        $path = new \BearFramework\App\Request\Path('/part1/part2/');
        $this->assertTrue((string) $path === '/part1/part2/');
        $this->assertTrue(isset($path[0]));
        $this->assertTrue(isset($path[1]));
        $this->assertFalse(isset($path[2]));
        $this->assertTrue($path[0] === 'part1');
        $this->assertTrue($path[1] === 'part2');
        $this->assertTrue($path[2] === null);

        $path = new \BearFramework\App\Request\Path('part1/part2');
        $this->assertTrue(isset($path[0]));
        $this->assertTrue(isset($path[1]));
        $this->assertFalse(isset($path[2]));
        $this->assertTrue($path[0] === 'part1');
        $this->assertTrue($path[1] === 'part2');
        $this->assertTrue($path[2] === null);

        $path = new \BearFramework\App\Request\Path('');
        $this->assertFalse(isset($path[0]));
        $this->assertTrue($path[0] === null);

        $path = new \BearFramework\App\Request\Path('/');
        $this->assertFalse(isset($path[0]));
        $this->assertTrue($path[0] === null);
    }

    /**
     * 
     */
    function testBaseInvalidArguments1()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->scheme = 1;
    }

    /**
     * 
     */
    function testBaseInvalidArguments2()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->host = 1;
    }

    /**
     * 
     */
    function testBaseInvalidArguments3a()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->port = [];
    }

    /**
     * 
     */
    function testBaseInvalidArguments3b()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->port = -1;
    }

    /**
     * 
     */
    function testBaseInvalidArguments3c()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->port = "wrong";
    }

    /**
     * 
     */
    function testBaseInvalidArguments3d()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->port = "-33";
    }

    /**
     * 
     */
    function testBaseInvalidArguments3e()
    {
        $request = new \BearFramework\App\Request();

        $this->setExpectedException('InvalidArgumentException');
        $request->port = 3.3;
    }

    /**
     * 
     */
    function testQuery()
    {
        $query = new \BearFramework\App\Request\Query();
        $query->set('var1', '1');
        $query->set('var2', 'a');
        $this->assertTrue((string) $query === 'var1=1&var2=a');
        $this->assertTrue($query->exists('var1'));
        $this->assertTrue($query->exists('var2'));
        $this->assertFalse($query->exists('var3'));
        $this->assertTrue($query->get('var1') === '1');
        $this->assertTrue($query->get('var2') === 'a');
        $this->assertTrue($query->get('var3') === null);

        $query = new \BearFramework\App\Request\Query();
        $this->assertFalse($query->exists('var1'));
        $this->assertTrue($query->get('var1') === null);
    }

    /**
     * 
     */
    function testHeaders()
    {
        $request = new \BearFramework\App\Request();
        $this->assertTrue(isset($request->headers));
        $request->headers->set('header1', '1');
        $this->assertTrue($request->headers->get('header1') === '1');
    }

    /**
     * 
     */
//    function testInvalidHeaders()
//    {
//        $request = new \BearFramework\App\Request();
//        $this->setExpectedException('InvalidArgumentException');
//        echo $request->headers = 1;
//    }

    /**
     * 
     */
    function testCookies()
    {
        $request = new \BearFramework\App\Request();
        $this->assertTrue(isset($request->cookies));
        $request->cookies->set('cookie1', '1');
        $this->assertTrue($request->cookies->get('cookie1') === '1');
    }

    /**
     * 
     */
    function testData()
    {
        $request = new \BearFramework\App\Request();
        $this->assertTrue(isset($request->data));
        $request->data->set('data1', '1');
        $this->assertTrue($request->data->get('data1') === '1');
    }

    /**
     * 
     */
    function testFiles()
    {
        $request = new \BearFramework\App\Request();
        $this->assertTrue(isset($request->files));
        $request->files->set('file1', 'file1.jpg', '/tmp/file1.jpg', 123);
        $this->assertTrue($request->files->get('file1')['filename'] === 'file1.jpg');
    }

}
