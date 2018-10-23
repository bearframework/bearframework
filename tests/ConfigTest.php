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
    public function testSet()
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
            'customOption' => 5
        ]);
        $this->assertTrue($config->customOption === 5);
    }

    /**
     * 
     */
    public function testGet2()
    {
        $config = new \BearFramework\App\Config();
        $this->expectException('Exception');
        echo $config->customOption;
    }

    /**
     * 
     */
    public function testIsset1()
    {
        $config = new \BearFramework\App\Config([
            'customOption' => 5
        ]);
        $this->assertTrue(isset($config->customOption));
    }

    /**
     * 
     */
    public function testIsset2()
    {
        $config = new \BearFramework\App\Config();
        $this->assertFalse(isset($config->customOption));
    }

    /**
     * 
     */
    public function testLoad()
    {
        $app = $this->getApp();
        $rootDir = $this->getTempDir();
        $filename = $rootDir . 'config.php';
        $this->makeFile($filename, '<?php
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
    public function testInvalidArguments1()
    {
        $app = $this->getApp();
        $this->expectException('InvalidArgumentException');
        $app->config->load('missing/file');
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $app = $this->getApp();
        $rootDir = $this->getTempDir();
        $filename = $rootDir . 'config.php';
        $this->makeFile($filename, '<?php
echo 1;
');
        $this->expectException('InvalidArgumentException');
        $app->config->load($filename);
    }

}
