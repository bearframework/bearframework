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
class ClassesTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAdd()
    {
        $app = new App();
        $app->classes->add('App\Log', '../src/App/Log.php');
        $app->classes->load('App\Log');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments1()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->classes->add(1, '../src/App/Log.php');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments2()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->classes->add('App\Log', 2);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments3()
    {
        $app = new App();
        $app->classes->add('App\Log', '../src/App/Log.php');
        $this->setExpectedException('InvalidArgumentException');
        $app->classes->load(1);
    }

}
