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
class AppTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testConstructor1()
    {
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_SCHEME'] = 'http';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['HTTP_X_CUSTOM_HEADER'] = '123';
        $_COOKIE['cookie1'] = 'value1';
        $_POST['name1'] = 'value1';
        $_POST['name2'] = [];
        $_POST['name2']['nameA'] = 'valueA';
        $_POST['name2']['nameB'] = 'valueB';
        $_GET['var1'] = '1';
        $_GET['var2'] = [];
        $_GET['var2']['varA'] = 'A';
        $_GET['var2']['varB'] = 'B';
        $app = new \BearFramework\App();
        $app->initialize();
        $this->assertTrue($app instanceof \BearFramework\App);
        $this->assertTrue(\BearFramework\App::get() instanceof \BearFramework\App);
        $this->assertTrue($app->request->method === 'GET');
        $this->assertTrue($app->request->scheme === 'http');
        $this->assertTrue($app->request->host === 'example.com');
        $this->assertTrue($app->request->base === 'http://example.com');
        $this->assertTrue((string) $app->request->path === '/');
        $this->assertTrue((string) $app->request->query === 'var1=1&var2%5BvarA%5D=A&var2%5BvarB%5D=B');
        $this->assertTrue($app->request->query->getValue('var1') === '1');
        $this->assertTrue($app->request->query->getValue('var2[varA]') === 'A');
        $this->assertTrue($app->request->query->getValue('var2[varB]') === 'B');
        $this->assertTrue($app->request->headers->getValue('X-Custom-Header') === '123');
        $this->assertTrue($app->request->cookies->getValue('cookie1') === 'value1');
        $this->assertTrue($app->request->formData->getValue('name1') === 'value1');
        $this->assertTrue($app->request->formData->getValue('name2[nameA]') === 'valueA');
        $this->assertTrue($app->request->formData->getValue('name2[nameB]') === 'valueB');
    }

    /**
     * 
     */
    public function testConstructor2()
    {
        $_SERVER['REQUEST_URI'] = '/www/';
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_SCHEME'] = 'https';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = '/www/index.php';
        $_GET['var1'] = '1';
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
    public function testConstructor3()
    {
        $_SERVER['REQUEST_URI'] = '/www/%D0%BF%D1%8A%D1%821/%D0%BF%D1%8A%D1%822/';
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_SCHEME'] = 'https';
        $_SERVER['SERVER_NAME'] = 'example.com';
        $_SERVER['SCRIPT_NAME'] = '/www/index.php';
        $app = new \BearFramework\App();
        $app->initialize();
        $this->assertTrue($app instanceof \BearFramework\App);
        $this->assertTrue($app->request->method === 'GET');
        $this->assertTrue($app->request->scheme === 'https');
        $this->assertTrue($app->request->host === 'example.com');
        $this->assertTrue($app->request->base === 'https://example.com/www');
        $this->assertTrue((string) $app->request->path === '/%D0%BF%D1%8A%D1%821/%D0%BF%D1%8A%D1%822/');
        $this->assertTrue((string) $app->request->path->getSegment(0) === 'път1');
        $this->assertTrue((string) $app->request->path->getSegment(1) === 'път2');
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
        $app = $this->getApp([], false, false);
        $this->makeFile($app->config->appDir . '/index.php', '<?php
$app = \BearFramework\App::get();
$app->routes->add(\'/\', function() {
    return new \BearFramework\App\Response(\'content\');
});
');
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
    function testMultipleApps()
    {
        $app = $this->getApp([], true);
        $this->expectException('Exception');
        $app = $this->getApp([], true);
    }

    /**
     * 
     */
    function testClone()
    {
        $app = $this->getApp();
        $this->expectException('Exception');
        clone($app);
    }

    /**
     * Disabled due to error in HHVM
     */
//    function testUnserialize()
//    {
//        $app = $this->getApp();
//        $this->expectException('Exception');
//        unserialize(serialize($app));
//    }

    /**
     * 
     */
    public function testNotCreatedApp()
    {
        $this->expectException('Exception');
        \BearFramework\App::get();
    }

    /**
     * 
     */
//    function testErrorInHooks1()
//    {
//        $app = $this->getApp();
//        $app->routes->add('/', function() {
//            return new \BearFramework\App\Response\HTML('content');
//        });
//        $app->hooks->add('responseCreated', function($response) {
//            if ($response instanceof \BearFramework\App\Response\HTML) {
//                echo 5 / 0;
//            }
//            if ($response instanceof \BearFramework\App\Response\TemporaryUnavailable) {
//                $response->content = 'sorry';
//            }
//        });
//        $app->run();
//        $this->expectOutputString('sorry');
//    }

    /**
     * 
     */
//    function testErrorInHooks2()
//    {
//        $app = $this->getApp();
//        $app->routes->add('/', function() {
//            return new \BearFramework\App\Response\HTML('content');
//        });
//        $app->hooks->add('responseCreated', function($response) {
//            if ($response instanceof \BearFramework\App\Response) {
//                $response->content = function() {
//                    echo 5 / 0;
//                };
//            }
//        });
//        $app->run();
//        $this->expectOutputString('');
//    }

    /**
     * 
     */
//    function testErrorInHooks3()
//    {
//        $app = $this->getApp();
//        $app->routes->add('/', function() {
//            return new \BearFramework\App\Response\HTML('content');
//        });
//        $app->hooks->add('responseCreated', function($response) {
//            if ($response instanceof \BearFramework\App\Response\HTML) {
//                $response->headers = 1;
//            }
//        });
//        $app->run();
//        $this->expectOutputString('Temporary Unavailable');
//    }
}
