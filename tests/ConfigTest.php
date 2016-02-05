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
class ConfigTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testConstructor()
    {
        $config = new App\Config([
            'displayErrors' => true
        ]);
        $this->assertTrue($config->displayErrors === true);
    }

    /**
     * 
     */
    public function testSet1a()
    {
        $config = new App\Config();
        $config->logErrors = true;
        $this->assertTrue($config->logErrors === true);
    }

    /**
     * 
     */
    public function testSet1b()
    {
        $config = new App\Config();
        $config->customVar = 5;
        $this->assertTrue($config->customVar === 5);
    }

    /**
     * y
     */
    public function testSet2()
    {
        $config = new App\Config();
        $this->setExpectedException('Exception');
        $config->handleErrors = false;
    }

    /**
     * 
     */
    public function testGet1()
    {
        $config = new App\Config([
            'displayErrors' => true
        ]);
        $this->assertTrue($config->displayErrors === true);
    }

    /**
     * 
     */
    public function testGet2()
    {
        $config = new App\Config([
            'customOption' => 5
        ]);
        $this->assertTrue($config->customOption === 5);
    }

    /**
     * 
     */
    public function testGet3()
    {
        $config = new App\Config();
        $this->assertTrue($config->customOption === null);
    }

    /**
     * 
     */
    public function testIsset1a()
    {
        $config = new App\Config();
        $this->assertTrue(isset($config->displayErrors));
    }

    /**
     * 
     */
    public function testIsset1b()
    {
        $config = new App\Config([
            'displayErrors' => true
        ]);
        $this->assertTrue(isset($config->displayErrors));
    }

    /**
     * 
     */
    public function testIsset2()
    {
        $config = new App\Config([
            'customOption' => 5
        ]);
        $this->assertTrue(isset($config->customOption));
    }

    /**
     * 
     */
    public function testIsset3()
    {
        $config = new App\Config();
        $this->assertFalse(isset($config->customOption));
    }

    /**
     * 
     */
    public function testDirectories()
    {
        $config = new App\Config([
            'appDir' => '../app',
            'addonsDir' => '../addons',
            'dataDir' => '../data',
            'logsDir' => '../logs',
        ]);
        $this->assertTrue($config->appDir === '../app/');
        $this->assertTrue($config->addonsDir === '../addons/');
        $this->assertTrue($config->dataDir === '../data/');
        $this->assertTrue($config->logsDir === '../logs/');

        $config = new App\Config([
            'appDir' => '../app/',
            'addonsDir' => '../addons/',
            'dataDir' => '../data/',
            'logsDir' => '../logs/',
        ]);
        $this->assertTrue($config->appDir === '../app/');
        $this->assertTrue($config->addonsDir === '../addons/');
        $this->assertTrue($config->dataDir === '../data/');
        $this->assertTrue($config->logsDir === '../logs/');
    }

    /**
     * 
     */
    public function testInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');
        new App\Config(2);
    }

}
