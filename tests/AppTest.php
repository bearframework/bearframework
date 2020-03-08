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
        $this->assertTrue($app instanceof \BearFramework\App);
        $this->assertTrue($app->request->method === 'GET');
        $this->assertTrue($app->request->scheme === 'https');
        $this->assertTrue($app->request->host === 'example.com');
        $this->assertTrue($app->request->base === 'https://example.com/www');
        $this->assertTrue((string) $app->request->path === '/път1/път2/');
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
        $app = $this->getApp([
            'appIndexContent' => '<?php
$app = \BearFramework\App::get();
$app->routes->add(\'/\', function() {
    return new \BearFramework\App\Response(\'content\');
});
'
        ]);
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
        $this->assertEquals(http_response_code(), 404);
    }

    /**
     * 
     */
    public function testSendResponse()
    {
        $app = $this->getApp();
        $app->send(new \BearFramework\App\Response('The end'));
        $this->expectOutputString('The end');
    }

    /**
     * 
     */
    function testMultipleApps()
    {
        $app = $this->makeApp();
        $this->expectException('Exception');
        $app = $this->makeApp();
    }

    /**
     * 
     */
    function testClone()
    {
        $app = $this->getApp();
        $this->expectException('Exception');
        clone ($app);
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
    function testBeforeSendResponseEvent()
    {
        $app = $this->getApp();
        $app->addEventListener('beforeSendResponse', function (\BearFramework\App\BeforeSendResponseEventDetails $details) {
            $details->response->content .= '2';
        });
        $this->expectOutputString('Hi2');
        $app->send(new \BearFramework\App\Response('Hi'));
    }

    /**
     * 
     */
    function testSendResponseEvent()
    {
        $app = $this->getApp();
        $app->addEventListener('sendResponse', function (\BearFramework\App\SendResponseEventDetails $details) {
            $details->response->content .= '2';
        });
        $this->expectOutputString('Hi');
        $response = new \BearFramework\App\Response('Hi');
        $app->send($response);
        $this->assertEquals($response->content, 'Hi2');
    }

    /**
     * 
     */
    public function testRangeRequest1()
    {
        $_SERVER['HTTP_RANGE'] = 'bytes=2-8';
        $app = new \BearFramework\App();
        $this->expectOutputString('2345678');
        $content = '0123456789';
        $response = new \BearFramework\App\Response($content);
        $response->headers->set($response->headers->make('Accept-Ranges', 'bytes'));
        $app->send($response);
    }

    /**
     * 
     */
    public function testRangeRequest2()
    {
        $_SERVER['HTTP_RANGE'] = 'bytes=5-';
        $app = new \BearFramework\App();
        $this->expectOutputString('56789');
        $content = '0123456789';
        $response = new \BearFramework\App\Response($content);
        $response->headers->set($response->headers->make('Accept-Ranges', 'bytes'));
        $app->send($response);
    }

    /**
     * 
     */
    public function testRangeRequest3()
    {
        $_SERVER['HTTP_RANGE'] = 'bytes=-4';
        $app = new \BearFramework\App();
        $this->expectOutputString('6789');
        $content = '0123456789';
        $response = new \BearFramework\App\Response($content);
        $response->headers->set($response->headers->make('Accept-Ranges', 'bytes'));
        $app->send($response);
    }

    /**
     * 
     */
    public function testRangeRequest4()
    {
        $_SERVER['HTTP_RANGE'] = 'bytes=3-8';
        $app = new \BearFramework\App();
        $this->expectOutputString('345678');
        $content = '0123456789';
        $filename = $this->getTempDir() . '/file';
        $this->makeFile($filename, $content);
        $response = new \BearFramework\App\Response\FileReader($filename);
        $response->headers->set($response->headers->make('Accept-Ranges', 'bytes'));
        $app->send($response);
    }
}
