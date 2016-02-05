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
        $app->hooks->add('sampleName', function() {
            echo '123';
        });
        $app->hooks->add('sampleName', function() {
            echo '456';
        });
        $app->hooks->execute('sampleName');
        $this->expectOutputString('123456');
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->add(1, function() {
            echo '123';
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
            echo '123';
        });
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->execute(1);
    }

}
