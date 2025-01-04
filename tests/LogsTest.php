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
class LogsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testLog()
    {
        $app = $this->getApp();

        $uniqueMessage = md5(uniqid());
        $name = 'warning';
        $filename = $app->config['logsDir'] . '/' . $name . '-' . date('Y-m-d') . '.log';
        $app->logs->log($name, $uniqueMessage);
        $this->assertTrue(is_file($filename) && strpos(file_get_contents($filename), $uniqueMessage) !== false);
    }

    /**
     * 
     */
    public function testInvalidLevelArgument()
    {
        $app = $this->getApp();

        $this->expectException('InvalidArgumentException');
        $app->logs->log('', 'message');
    }

    /**
     * 
     */
    public function testInvalidFile()
    {
        $app = $this->getApp();
        $name = 'warning';
        $filename = $app->config['logsDir'] . '/' . $name . '-' . date('Y-m-d') . '.log';
        mkdir($filename, 0777, true);
        $this->expectException('\Exception');
        $app->logs->log($name, 'message');
    }

    /**
     * 
     */
    public function testNullLogger()
    {
        $app = new \BearFramework\App();
        $app->logs->useNullLogger();
        $app->logs->log('error', 'message');
        $this->assertTrue(true);
    }
}
