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

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response(1);
    }

    /**
     * 
     */
    function testHTMLResponse()
    {
        $response = new \BearFramework\App\Response\HTML('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\HTML(1);
    }

    /**
     * 
     */
    function testTextResponse()
    {
        $response = new \BearFramework\App\Response\Text('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\Text(1);
    }

    /**
     * 
     */
    function testJSONResponse()
    {
        $response = new \BearFramework\App\Response\JSON('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\JSON(1);
    }

    /**
     * 
     */
    function testNotFoundResponse()
    {
        $response = new \BearFramework\App\Response\NotFound('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\NotFound(1);
    }

    /**
     * 
     */
    function testPermanentRedirectResponse()
    {
        $response = new \BearFramework\App\Response\PermanentRedirect('url');
        $this->assertTrue($response->headers['location'] === 'Location: url');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\PermanentRedirect(1);
    }

    /**
     * 
     */
    function testTemporaryRedirectResponse()
    {
        $response = new \BearFramework\App\Response\TemporaryRedirect('url');
        $this->assertTrue($response->headers['location'] === 'Location: url');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\TemporaryRedirect(1);
    }

    /**
     * 
     */
    function testTemporaryUnavailableResponse()
    {
        $response = new \BearFramework\App\Response\TemporaryUnavailable('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\TemporaryUnavailable(1);
    }

    /**
     * 
     */
    function testResponseMaxAge()
    {
        $response = new \BearFramework\App\Response('content');
        $response->setMaxAge(10);
        $this->assertTrue($response->headers['cacheControl'] === 'Cache-Control: public, max-age=10');
    }

    /**
     * 
     */
    function testResponseInvalidMaxAge1()
    {
        $response = new \BearFramework\App\Response('content');
        $this->setExpectedException('InvalidArgumentException');
        $response->setMaxAge('3');
    }

    /**
     * 
     */
    function testResponseInvalidMaxAge2()
    {
        $response = new \BearFramework\App\Response('content');
        $this->setExpectedException('InvalidArgumentException');
        $response->setMaxAge(-1);
    }

    /**
     * 
     */
    function testResponseContentType()
    {
        $response = new \BearFramework\App\Response('content');
        $response->setContentType('text/json');
        $this->assertTrue($response->headers['contentType'] === 'Content-Type: text/json; charset=UTF-8');
    }

    /**
     * 
     */
    function testResponseInvalidContentType()
    {
        $response = new \BearFramework\App\Response('content');
        $this->setExpectedException('InvalidArgumentException');
        $response->setContentType(1);
    }

    /**
     * 
     */
    function testResponseStatusCode()
    {
        $response = new \BearFramework\App\Response('content');
        $response->setStatusCode(404);
        $this->assertTrue($response->headers['statusCode'] === (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1') . ' 404 Not Found');
    }

    /**
     * 
     */
    function testResponseInvalidStatusCode1()
    {
        $response = new \BearFramework\App\Response('content');
        $this->setExpectedException('InvalidArgumentException');
        $response->setStatusCode(111);
    }

    /**
     * 
     */
    function testResponseInvalidStatusCode2()
    {
        $response = new \BearFramework\App\Response('content');
        $this->setExpectedException('InvalidArgumentException');
        $response->setStatusCode('777');
    }

}
