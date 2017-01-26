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
class ResponseTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    function testResponse()
    {
        $response = new \BearFramework\App\Response('content');
        $this->assertTrue($response->content === 'content');
        $response->statusCode = 307;
        $this->assertTrue($response->statusCode === 307);
        $response->charset = 'UTF-8';
        $this->assertTrue($response->charset === 'UTF-8');

        $this->assertTrue(isset($response->content));
        $this->assertTrue(isset($response->statusCode));
        $this->assertTrue(isset($response->charset));

        unset($response->content);
        unset($response->statusCode);
        unset($response->charset);
        $this->assertTrue($response->content === '');
        $this->assertTrue($response->statusCode === null);
        $this->assertTrue($response->charset === null);

        $this->assertTrue(isset($response->headers));
        $this->assertTrue(isset($response->cookies));
    }

    /**
     * 
     */
    function testResponseHeaders()
    {
        $app = $this->getApp();
        $response = new \BearFramework\App\Response('Hi');
        $response->cookies->set($response->cookies->make('name1', 'value1'));
        $response->headers->set($response->headers->make('X-My-Header', '1'));
        $app->respond($response);
        $this->expectOutputString('Hi');
    }

    /**
     * 
     */
    function testHTMLResponse()
    {
        $response = new \BearFramework\App\Response\HTML('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    function testTextResponse()
    {
        $response = new \BearFramework\App\Response\Text('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    function testJSONResponse()
    {
        $response = new \BearFramework\App\Response\JSON('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    function testNotFoundResponse()
    {
        $response = new \BearFramework\App\Response\NotFound('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    function testPermanentRedirectResponse()
    {
        $response = new \BearFramework\App\Response\PermanentRedirect('url');
        $this->assertTrue($response->headers->getValue('Location') === 'url');
    }

    /**
     * 
     */
    function testTemporaryRedirectResponse()
    {
        $response = new \BearFramework\App\Response\TemporaryRedirect('url');
        $this->assertTrue($response->headers->getValue('Location') === 'url');
    }

    /**
     * 
     */
    function testTemporaryUnavailableResponse()
    {
        $response = new \BearFramework\App\Response\TemporaryUnavailable('content');
        $this->assertTrue($response->content === 'content');
    }

    /**
     * 
     */
    function testResponseStatusCode()
    {
        $response = new \BearFramework\App\Response('content');
        $response->statusCode = 404;
        $this->assertTrue($response->statusCode === 404);
    }

}
