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

        $this->assertTrue(isset($response->headers));
        $this->assertTrue(isset($response->cookies));

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response(1);
    }

    /**
     * 
     */
    function testResponseHeaders()
    {
        $app = $this->getApp();
        $app->initialize();
        $response = new \BearFramework\App\Response('Hi');
        $response->cookies->set('name1', 'value1');
        $response->headers->set('X-My-Header', '1');
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
        $this->assertTrue($response->headers->get('Location') === 'url');

        $this->setExpectedException('Exception');
        $response = new \BearFramework\App\Response\PermanentRedirect(1);
    }

    /**
     * 
     */
    function testTemporaryRedirectResponse()
    {
        $response = new \BearFramework\App\Response\TemporaryRedirect('url');
        $this->assertTrue($response->headers->get('Location') === 'url');

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
    function testResponseStatusCode()
    {
        $response = new \BearFramework\App\Response('content');
        $response->statusCode = 404;
        $this->assertTrue($response->statusCode === 404);
    }

    /**
     * 
     */
    function testInvalidGet()
    {
        $response = new \BearFramework\App\Response();
        $this->setExpectedException('Exception');
        echo $response->missing;
    }

}
