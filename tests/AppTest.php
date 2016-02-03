<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * 
 */
class AppTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testConstructor()
    {
        $_SERVER['REQUEST_URI'] = '/www/?var1=1';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_SCHEME'] = 'http';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = '/www/index.php';
        $app = new App();
        $this->assertTrue($app instanceof App);
        $this->assertTrue($app->request->method === 'GET');
        $this->assertTrue($app->request->scheme === 'http');
        $this->assertTrue($app->request->host === 'example.com');
        $this->assertTrue($app->request->base === 'http://example.com/www');
        $this->assertTrue((string) $app->request->path === '/');
        $this->assertTrue((string) $app->request->query === 'var1=1');
    }

    /**
     * 
     */
    public function testAutoload()
    {
        $this->assertTrue(class_exists('\App\Response'));
        $this->assertFalse(class_exists('\App\MissingClass'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testLoad()
    {
        $app = new App();
        $this->assertTrue($app->load('src/App/Cache.php'));
        $this->assertFalse($app->load('src/App/MissingClass.php'));
        $this->setExpectedException('InvalidArgumentException');
        $app->load(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrl()
    {
        $app = new App();
        $app->request->base = "https://example.com/www";
        $this->assertTrue($app->getUrl('/') === "https://example.com/www/");
        $this->assertTrue($app->getUrl('/products/') === "https://example.com/www/products/");
        $this->setExpectedException('InvalidArgumentException');
        $app->getUrl(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testRunNotFound()
    {
        $app = new App();
        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * @runInSeparateProcess
     */
    public function testRespond()
    {
        $app = new App();
        $app->respond(new \App\Response('The end'));
        $this->expectOutputString('The end');
    }

    /**
     * @runInSeparateProcess
     */
    public function testRespondInvalidArgument()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->respond(1);
    }

    /**
     * @runInSeparateProcess
     */
    function testMultipleApps()
    {
        $app = new App();
        $this->setExpectedException('Exception');
        $app = new App();
    }

}
