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
class HooksTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAdd()
    {
        $app = $this->getApp();
        $this->assertFalse($app->hooks->exists('sampleName'));
        $result = '';
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '123';
        });
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '456';
        });
        $this->assertTrue($app->hooks->exists('sampleName'));
        $app->hooks->execute('sampleName');
        $this->assertTrue($result === '123456');
    }

    /**
     * 
     */
    public function testPriority()
    {
        $app = $this->getApp();
        $result = '';
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '78';
        }, ['priority' => 101]);
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '34';
        });
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '56';
        });
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '12';
        }, ['priority' => 99]);
        $app->hooks->execute('sampleName');
        $this->assertTrue($result === '12345678');
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->add(1, function() {
            
        });
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->add('sampleName', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $app = $this->getApp();
        $app->hooks->add('sampleName', function() {
            
        });
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->execute(1);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->add('sampleName', function() {
            
        }, 1);
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->exists(1);
    }

}
