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
class ResponseTypesTest extends BearFrameworkTestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testFileReader()
    {
        $response = new App\Response\FileReader('filename.txt');
        $this->assertTrue($response->filename === 'filename.txt');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\FileReader(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testHTML()
    {
        $response = new App\Response\HTML('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\HTML(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testJSON()
    {
        $response = new App\Response\JSON('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\JSON(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testText()
    {
        $response = new App\Response\Text('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\Text(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testNotFound()
    {
        $response = new App\Response\NotFound('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\NotFound(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testTemporaryUnavailable()
    {
        $response = new App\Response\TemporaryUnavailable('content');
        $this->assertTrue($response->content === 'content');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\TemporaryUnavailable(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testPermanentRedirect()
    {
        $response = new App\Response\PermanentRedirect('http://example.com/');
        $this->assertTrue($response->headers['location'] === 'Location: http://example.com/');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\PermanentRedirect(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testTemporaryRedirect()
    {
        $response = new App\Response\TemporaryRedirect('http://example.com/');
        $this->assertTrue($response->headers['location'] === 'Location: http://example.com/');

        $this->setExpectedException('InvalidArgumentException');
        $response = new App\Response\TemporaryRedirect(1);
    }

}
