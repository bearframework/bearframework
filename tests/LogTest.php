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
class LogTest extends BearFrameworkTestCase
{

    /**
     * @runInSeparateProcess
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
     * @runInSeparateProcess
     */
    public function testInvalidFilenameArgument1()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->log->write(1, 'data');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidDataArgument()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->log->write('file.log', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidConfigOption()
    {
        $app = $this->getApp([
            'logsDir' => null
        ]);

        $this->setExpectedException('App\InvalidConfigOptionException');
        $app->log->write('file.log', 'data');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidFile()
    {
        $app = $this->getApp();
        App\Utilities\Dir::make($app->config->logsDir . 'file');
        $this->assertFalse($app->log->write('file', 'body'));
    }

}
