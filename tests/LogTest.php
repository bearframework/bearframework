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
class LogTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testWrite()
    {
        $app = $this->getApp();

        $uniqueContent = md5(uniqid());
        $file = uniqid() . '.log';
        $filename = $app->config->logsDir . $file;
        $this->assertTrue($app->log->write($file, $uniqueContent));
        $this->assertTrue(is_file($filename) && strpos(file_get_contents($filename), $uniqueContent) !== false);

        $uniqueContent = md5(uniqid());
        $dir = uniqid();
        $file = uniqid() . '.log';
        $filename = $app->config->logsDir . $dir . '/' . $file . '.log';
        $this->assertTrue($app->log->write($dir . '/' . $file . '.log', $uniqueContent));
        $this->assertTrue(is_file($filename) && strpos(file_get_contents($filename), $uniqueContent) !== false);
    }

    /**
     * 
     */
    public function testInvalidFilenameArgument1()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->log->write(1, 'data');
    }

    /**
     * 
     */
    public function testInvalidDataArgument()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->log->write('file.log', 1);
    }

    /**
     * 
     */
    public function testInvalidConfigOption()
    {
        $app = $this->getApp([
            'logsDir' => null
        ]);

        $this->setExpectedException('\BearFramework\App\InvalidConfigOptionException');
        $app->log->write('file.log', 'data');
    }

    /**
     * 
     */
    public function testInvalidFile()
    {
        $app = $this->getApp();
        \BearFramework\App\Utilities\Dir::make($app->config->logsDir . 'file');
        $this->assertFalse($app->log->write('file', 'body'));
    }

}
