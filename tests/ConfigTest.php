<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
        $this->setExpectedException('Exception');
        echo $config->customOption;
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
        $app = $this->getApp();
        $rootDir = $this->getTestDir();
        $this->createDir($rootDir . 'app');
        $this->createDir($rootDir . 'data');
        $this->createDir($rootDir . 'logs');
        $config = new \BearFramework\App\Config([
            'appDir' => $rootDir . 'app',
            'dataDir' => $rootDir . 'data',
            'logsDir' => $rootDir . 'logs',
        ]);
        $this->assertTrue($config->appDir === realpath($rootDir . 'app'));
        $this->assertTrue($config->dataDir === realpath($rootDir . 'data'));
        $this->assertTrue($config->logsDir === realpath($rootDir . 'logs'));

        $config = new \BearFramework\App\Config();
        $config->appDir = $rootDir . 'app/';
        $config->dataDir = $rootDir . 'data/';
        $config->logsDir = $rootDir . 'logs/';
        $this->assertTrue($config->appDir === realpath($rootDir . 'app'));
        $this->assertTrue($config->dataDir === realpath($rootDir . 'data'));
        $this->assertTrue($config->logsDir === realpath($rootDir . 'logs'));
    }

    /**
     * 
     */
    public function testLoad()
    {
        $app = $this->getApp();
        $rootDir = $this->getTestDir();
        $filename = $rootDir . 'config.php';
        $this->createFile($filename, '<?php
return [
    "option1" => "one",
    "option2" => 2,
    "option3" => [3, true]
];
');
        $app->config->load($filename);
        $this->assertTrue($app->config->option1 === "one");
        $this->assertTrue($app->config->option2 === 2);
        $this->assertTrue($app->config->option3[0] === 3);
        $this->assertTrue($app->config->option3[1] === true);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $this->setExpectedException('Exception');
        new \BearFramework\App\Config([
            'appDir' => 'missing/dir'
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $this->setExpectedException('Exception');
        new \BearFramework\App\Config([
            'dataDir' => 'missing/dir'
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $this->setExpectedException('Exception');
        new \BearFramework\App\Config([
            'logsDir' => 'missing/dir'
        ]);
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $config = new \BearFramework\App\Config();
        $this->setExpectedException('Exception');
        $config->appDir = 'missing/dir';
    }

    /**
     * 
     */
    public function testInvalidArguments6()
    {
        $config = new \BearFramework\App\Config();
        $this->setExpectedException('Exception');
        $config->dataDir = 'missing/dir';
    }

    /**
     * 
     */
    public function testInvalidArguments7()
    {
        $config = new \BearFramework\App\Config();
        $this->setExpectedException('Exception');
        $config->logsDir = 'missing/dir';
    }

    /**
     * 
     */
    public function testInvalidArguments9()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->config->load('missing/file');
    }

    /**
     * 
     */
    public function testInvalidArguments10()
    {
        $app = $this->getApp();
        $rootDir = $this->getTestDir();
        $filename = $rootDir . 'config.php';
        $this->createFile($filename, '<?php
echo 1;
');
        $this->setExpectedException('InvalidArgumentException');
        $app->config->load($filename);
    }

}
