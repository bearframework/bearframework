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
class LogTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testLog()
    {
        $app = $this->getApp();

        $uniqueMessage = md5(uniqid());
        $level = 'warning';
        $filename = $app->config->logsDir . '/' . $level . '-' . date('Y-m-d') . '.log';
        $app->logger->log($level, $uniqueMessage);
        $this->assertTrue(is_file($filename) && strpos(file_get_contents($filename), $uniqueMessage) !== false);
    }

    /**
     * 
     */
    public function testInvalidLevelArgument()
    {
        $app = $this->getApp();

        $this->expectException('InvalidArgumentException');
        $app->logger->log('', 'message');
    }

    /**
     * 
     */
    public function testInvalidFile()
    {
        $app = $this->getApp();
        $level = 'warning';
        $filename = $app->config->logsDir . '/' . $level . '-' . date('Y-m-d') . '.log';
        mkdir($filename, 0777, true);
        $this->expectException('\Exception');
        $app->logger->log($level, 'message');
    }

}
