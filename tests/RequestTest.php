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
class RequestTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function testProperties()
    {
        $request = new \BearFramework\App\Request();
        $request->method = 'GET';
        $request->base = 'http://example.com:8888';
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
        $this->assertTrue(isset($request->formData));
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

        $this->assertTrue($request->base === 'https://subdomain.example.com:8888');

        $request->port = null;
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
        $path = new \BearFramework\App\Request\PathRepository('/part1/part2/');
        $this->assertTrue((string) $path === '/part1/part2/');
        $this->assertTrue($path->getSegment(0) === 'part1');
        $this->assertTrue($path->getSegment(1) === 'part2');
        $this->assertTrue($path->getSegment(2) === null);

        $path = new \BearFramework\App\Request\PathRepository('part1/part2');
        $this->assertTrue($path->getSegment(0) === 'part1');
        $this->assertTrue($path->getSegment(1) === 'part2');
        $this->assertTrue($path->getSegment(2) === null);

        $path = new \BearFramework\App\Request\PathRepository('');
        $this->assertTrue($path->getSegment(0) === null);

        $path = new \BearFramework\App\Request\PathRepository('/');
        $this->assertTrue($path->getSegment(0) === null);
    }

    /**
     * 
     */
    function testQuery()
    {
        $query = new \BearFramework\App\Request\QueryRepository();
        $query->set($query->make('var1', '1'));
        $query->set($query->make('var2', 'a'));
        $this->assertTrue((string) $query === 'var1=1&var2=a');
        $this->assertTrue($query->exists('var1'));
        $this->assertTrue($query->exists('var2'));
        $this->assertFalse($query->exists('var3'));
        $this->assertTrue($query->getValue('var1') === '1');
        $this->assertTrue($query->getValue('var2') === 'a');
        $this->assertTrue($query->getValue('var3') === null);

        $query = new \BearFramework\App\Request\QueryRepository();
        $this->assertFalse($query->exists('var1'));
        $this->assertTrue($query->getValue('var1') === null);
    }

    /**
     * 
     */
    function testHeaders()
    {
        $request = new \BearFramework\App\Request();
        $this->assertTrue(isset($request->headers));
        $request->headers->set($request->headers->make('header1', '1'));
        $this->assertTrue($request->headers->getValue('header1') === '1');
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
        $request->cookies->set($request->cookies->make('cookie1', '1'));
        $this->assertTrue($request->cookies->getValue('cookie1') === '1');
    }

    /**
     * 
     */
    function testData()
    {
        $request = new \BearFramework\App\Request();
        $this->assertTrue(isset($request->formData));
        $request->formData->set($request->formData->make('data1', '1'));
        $this->assertTrue($request->formData->getValue('data1') === '1');
    }

    /**
     * 
     */
    function testFiles()
    {
        $request = new \BearFramework\App\Request();
        $this->assertTrue(isset($request->formData));
        $file = new \BearFramework\App\Request\FormDataFileItem();
        $file->name = 'file1';
        $file->value = 'file1.jpg';
        $file->filename = '/tmp/file1.jpg';
        $file->size = 123;
        $request->formData->set($file);
        $this->assertTrue($request->formData->getFile('file1')->value === 'file1.jpg');
        $this->assertTrue($request->formData->getFile('file1')->filename === '/tmp/file1.jpg');
        $this->assertTrue($request->formData->getFile('file1')->size === 123);
    }

}
