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
        $app = $this->getApp();
        $this->createFile($app->config->appDir . '/file', '123');
        $response = new \BearFramework\App\Response\FileReader($app->config->appDir . '/file');
        $this->assertTrue($response->filename === realpath($app->config->appDir . '/file'));
        $this->assertTrue(isset($response->filename));
        unset($response->filename);
        $this->assertTrue($response->filename === '');
    }

    /**
     * 
     */
    public function testFileReader2()
    {
        $app = $this->getApp();
        $this->createFile($app->config->appDir . '/file', '123');
        $app->routes->add('/', function() use ($app) {
            return new \BearFramework\App\Response\FileReader($app->config->appDir . '/file');
        });
        $app->run();
        $this->expectOutputString('123');
    }

    /**
     * 
     */
    public function testFileReaderInvalidArgument1()
    {
        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\FileReader(1);
    }

    /**
     * 
     */
    public function testFileReaderInvalidArgument2()
    {
        $this->setExpectedException('InvalidArgumentException');
        $response = new \BearFramework\App\Response\FileReader('missing/file');
    }

    /**
     * 
     */
    public function testHTML()
    {
        $response = new \BearFramework\App\Response\HTML('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    public function testJSON()
    {
        $response = new \BearFramework\App\Response\JSON('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    public function testText()
    {
        $response = new \BearFramework\App\Response\Text('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    public function testNotFound()
    {
        $response = new \BearFramework\App\Response\NotFound('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    public function testTemporaryUnavailable()
    {
        $response = new \BearFramework\App\Response\TemporaryUnavailable('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    public function testPermanentRedirect()
    {
        $response = new \BearFramework\App\Response\PermanentRedirect('http://example.com/');
        $this->assertTrue($response->headers->getValue('Location') === 'http://example.com/');
    }

    /**
     * 
     */
    public function testTemporaryRedirect()
    {
        $response = new \BearFramework\App\Response\TemporaryRedirect('http://example.com/');
        $this->assertTrue($response->headers->getValue('Location') === 'http://example.com/');
    }

}
