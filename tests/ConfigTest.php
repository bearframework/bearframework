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
        $config = new \BearFramework\App\Config([
            'displayErrors' => true
        ]);
        $this->assertTrue($config->displayErrors === true);
    }

    /**
     * 
     */
    public function testSet1a()
    {
        $config = new \BearFramework\App\Config();
        $config->logErrors = true;
        $this->assertTrue($config->logErrors === true);
    }

    /**
     * 
     */
    public function testSet1b()
    {
        $config = new \BearFramework\App\Config();
        $config->customVar = 5;
        $this->assertTrue($config->customVar === 5);
    }

    /**
     * 
     */
    public function testGet1()
    {
        $config = new \BearFramework\App\Config([
            'displayErrors' => true
        ]);
        $this->assertTrue($config->displayErrors === true);
    }

    /**
     * 
     */
    public function testGet2()
    {
        $config = new \BearFramework\App\Config([
            'customOption' => 5
        ]);
        $this->assertTrue($config->customOption === 5);
    }

    /**
     * 
     */
    public function testGet3()
    {
        $config = new \BearFramework\App\Config();
        $this->assertTrue($config->customOption === null);
    }

    /**
     * 
     */
    public function testIsset1a()
    {
        $config = new \BearFramework\App\Config();
        $this->assertTrue(isset($config->displayErrors));
    }

    /**
     * 
     */
    public function testIsset1b()
    {
        $config = new \BearFramework\App\Config([
            'displayErrors' => true
        ]);
        $this->assertTrue(isset($config->displayErrors));
    }

    /**
     * 
     */
    public function testIsset2()
    {
        $config = new \BearFramework\App\Config([
            'customOption' => 5
        ]);
        $this->assertTrue(isset($config->customOption));
    }

    /**
     * 
     */
    public function testIsset3()
    {
        $config = new \BearFramework\App\Config();
        $this->assertFalse(isset($config->customOption));
    }

    /**
     * 
     */
    public function testDirectories()
    {
        $config = new \BearFramework\App\Config([
            'appDir' => '../app',
            'dataDir' => '../data',
            'logsDir' => '../logs',
        ]);
        $this->assertTrue($config->appDir === '../app/');
        $this->assertTrue($config->dataDir === '../data/');
        $this->assertTrue($config->logsDir === '../logs/');

        $config = new \BearFramework\App\Config([
            'appDir' => '../app/',
            'dataDir' => '../data/',
            'logsDir' => '../logs/',
        ]);
        $this->assertTrue($config->appDir === '../app/');
        $this->assertTrue($config->dataDir === '../data/');
        $this->assertTrue($config->logsDir === '../logs/');
    }

    /**
     * 
     */
    public function testInvalidArgument()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Config(2);
    }

}
