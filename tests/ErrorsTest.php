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
class TestApp extends App
{

    function testHandleLastError($errorData)
    {
        parent::handleLastError($errorData);
    }

}

class ErrorsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    function testException()
    {
//        $app = new App();
//        echo 5 / 0;
//        $this->expectOutputString('Temporary Unavailable');
    }

    /**
     * @runInSeparateProcess
     */
    function testDevelopmentError()
    {
//        $app = new App([
//            'displayErrors' => true
//        ]);
//        echo 1 / 0;
//        $this->expectOutputRegex('/(.*)Message\:(.*)/');
    }

    /**
     * @runInSeparateProcess
     */
    function testErrorsLog()
    {
//        $app = new App([
//            'logErrors' => true,
//            'errorLogFilename' => __DIR__ . '/error.log'
//        ]);
//        echo 1 / 0;
//        $this->assertTrue(is_file(__DIR__ . '/error.log'));
//        $this->assertTrue(strpos(file_get_contents(__DIR__ . '/error.log'), 'Message:') !== false);
//        $this->assertTrue(unlink(__DIR__ . '/error.log'));
    }

}
