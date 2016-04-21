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
class ClassesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAdd()
    {
        $app = $this->getApp();
        $this->createFile($app->config->appDir . '/tempClass1.php', '<?php class TempClass1{}');
        $app->classes->add('TempClass1', $app->config->appDir . '/tempClass1.php');
        $this->assertTrue(class_exists('TempClass1'));
    }

    /**
     * 
     */
    public function testAddInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->classes->add(1, '../src/App/Log.php');
    }

    /**
     * 
     */
    public function testAddInvalidArguments2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->classes->add('\BearFramework\App\Log', 2);
    }

    /**
     * 
     */
    public function testAddInvalidArguments3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->classes->add('\BearFramework\App\Log', '../src/App/MissingFile.php');
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->classes->load(1);
    }

}
