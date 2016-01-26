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
class LogTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testWrite()
    {
        $app = new App([
            'logsDir' => sys_get_temp_dir()
        ]);

        $uniqueContent = md5(uniqid());
        $file = uniqid() . '.log';
        $filename = sys_get_temp_dir() . '/' . $file;
        $this->assertTrue($app->log->write($file, $uniqueContent));
        $this->assertTrue(is_file($filename) && strpos(file_get_contents($filename), $uniqueContent) !== false);

        $uniqueContent = md5(uniqid());
        $dir = uniqid();
        $file = uniqid() . '.log';
        $filename = sys_get_temp_dir() . '/' . $dir . '/' . $file . '.log';
        $this->assertTrue($app->log->write($dir . '/' . $file . '.log', $uniqueContent));
        $this->assertTrue(is_file($filename) && strpos(file_get_contents($filename), $uniqueContent) !== false);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidFilenameArgument1()
    {
        $app = new App([
            'logsDir' => sys_get_temp_dir()
        ]);

        $this->setExpectedException('InvalidArgumentException');
        $app->log->write(1, 'data');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidFilenameArgument2()
    {
        $app = new App([
            'logsDir' => sys_get_temp_dir()
        ]);

        $this->assertFalse($app->log->write('/!@#$%^&*()', 'data'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidDataArgument()
    {
        $app = new App([
            'logsDir' => sys_get_temp_dir()
        ]);

        $this->setExpectedException('InvalidArgumentException');
        $app->log->write('file.log', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidConfigOption()
    {
        $app = new App();

        $this->setExpectedException('Exception');
        $app->log->write('file.log', 'data');
    }

}
