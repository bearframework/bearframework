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
class HooksTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAdd()
    {
        $app = new App();
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
     * @runInSeparateProcess
     */
    public function testInvalidArguments1()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->add(1, function() {
            echo '123';
        });
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments2()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->add('sampleName', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments3()
    {
        $app = new App();
        $app->hooks->add('sampleName', function() {
            echo '123';
        });
        $this->setExpectedException('InvalidArgumentException');
        $app->hooks->execute(1);
    }

}
