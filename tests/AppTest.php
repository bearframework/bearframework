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
class AppTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testConstructor1()
    {
        $_SERVER['REQUEST_URI'] = '/?var1=1';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_SCHEME'] = 'http';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $app = new \BearFramework\App();
        $app->initialize();
        $this->assertTrue($app instanceof \BearFramework\App);
        $this->assertTrue($app->request->method === 'GET');
        $this->assertTrue($app->request->scheme === 'http');
        $this->assertTrue($app->request->host === 'example.com');
        $this->assertTrue($app->request->base === 'http://example.com');
        $this->assertTrue((string) $app->request->path === '/');
        $this->assertTrue((string) $app->request->query === 'var1=1');
    }

    /**
     * 
     */
    public function testConstructor2()
    {
        $_SERVER['REQUEST_URI'] = '/www/?var1=1';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_SCHEME'] = 'https';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = '/www/index.php';
        $app = new \BearFramework\App();
        $app->initialize();
        $this->assertTrue($app instanceof \BearFramework\App);
        $this->assertTrue($app->request->method === 'POST');
        $this->assertTrue($app->request->scheme === 'https');
        $this->assertTrue($app->request->host === 'example.com');
        $this->assertTrue($app->request->base === 'https://example.com/www');
        $this->assertTrue((string) $app->request->path === '/');
        $this->assertTrue((string) $app->request->query === 'var1=1');
    }

    /**
     * 
     */
    public function testUglyURLs()
    {
        $_SERVER['REQUEST_URI'] = '/www/index.php/path1/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_SCHEME'] = 'http';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = '/www/index.php';
        $app = $this->getApp();
        $this->assertTrue($app instanceof \BearFramework\App);
        $this->assertTrue($app->request->base === 'http://example.com/www');
        $this->assertTrue((string) $app->request->path === '/path1/');
    }

    /**
     * 
     */
    public function testAutoload()
    {
        $this->assertTrue(class_exists('\BearFramework\App\Response'));
        $this->assertFalse(class_exists('\BearFramework\App\MissingClass'));
    }

    /**
     * 
     */
    public function testAppIndex()
    {
        $app = $this->getApp();
        $this->createFile($app->config->appDir . 'index.php', '<?php

');
        // todo - must be inside index.php
        $app->routes->add('/', function() {
            return new \BearFramework\App\Response('content');
        });
        $app->run();
        $this->expectOutputString('content');
    }

    /**
     * 
     */
    public function testRunNotFound()
    {
        $app = $this->getApp();
        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * 
     */
    public function testRespond()
    {
        $app = $this->getApp();
        $app->respond(new \BearFramework\App\Response('The end'));
        $this->expectOutputString('The end');
    }

    /**
     * 
     */
    public function testRespondInvalidArgument()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->respond(1);
    }

    /**
     * 
     */
    function testMultipleApps()
    {
        $app = $this->getApp([], true);
        $this->setExpectedException('Exception');
        $app = $this->getApp([], true);
    }

    /**
     * 
     */
    function testClone()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        clone($app);
    }

    /**
     * 
     */
    function testUnserialize()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        unserialize(serialize($app));
    }

}
