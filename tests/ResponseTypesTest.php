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
class ResponseTypesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testFileReader1()
    {
        $response = new \BearFramework\App\Response\FileReader('filename.txt');
        $this->assertTrue($response->filename === 'filename.txt');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\FileReader(1);
    }

    /**
     * 
     */
    public function testFileReader2()
    {
        $app = $this->getApp();
        $this->createFile($app->config->appDir . 'file', '123');
        $app->routes->add('/', function() use ($app) {
            return new \BearFramework\App\Response\FileReader($app->config->appDir . 'file');
        });
        $app->run();
        $this->expectOutputString('123');
    }

    /**
     * 
     */
    public function testHTML()
    {
        $response = new \BearFramework\App\Response\HTML('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\HTML(1);
    }

    /**
     * 
     */
    public function testJSON()
    {
        $response = new \BearFramework\App\Response\JSON('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\JSON(1);
    }

    /**
     * 
     */
    public function testText()
    {
        $response = new \BearFramework\App\Response\Text('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\Text(1);
    }

    /**
     * 
     */
    public function testNotFound()
    {
        $response = new \BearFramework\App\Response\NotFound('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\NotFound(1);
    }

    /**
     * 
     */
    public function testTemporaryUnavailable()
    {
        $response = new \BearFramework\App\Response\TemporaryUnavailable('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\TemporaryUnavailable(1);
    }

    /**
     * 
     */
    public function testPermanentRedirect()
    {
        $response = new \BearFramework\App\Response\PermanentRedirect('http://example.com/');
        $this->assertTrue($response->headers['location'] === 'Location: http://example.com/');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\PermanentRedirect(1);
    }

    /**
     * 
     */
    public function testTemporaryRedirect()
    {
        $response = new \BearFramework\App\Response\TemporaryRedirect('http://example.com/');
        $this->assertTrue($response->headers['location'] === 'Location: http://example.com/');

        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\TemporaryRedirect(1);
    }

}
