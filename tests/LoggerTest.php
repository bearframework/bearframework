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
    public function testLog()
    {
        $app = $this->getApp();

        $uniqueMessage = md5(uniqid());
        $level = 'warning';
        $filename = $app->config->logsDir . $level . '-' . date('Y-m-d') . '.log';
        $this->assertTrue($app->logger->log($level, $uniqueMessage));
        $this->assertTrue(is_file($filename) && strpos(file_get_contents($filename), $uniqueMessage) !== false);
    }

    /**
     * 
     */
    public function testInvalidLevelArgument()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->logger->log('', 'message');
    }

    /**
     * 
     */
    public function testInvalidMessageArgument()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->logger->log('warning', 1);
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
        $app->logger->log('warning', 'message');
    }

    /**
     * 
     */
    public function testInvalidFile()
    {
        $app = $this->getApp();
        $level = 'warning';
        $filename = $app->config->logsDir . $level . '-' . date('Y-m-d') . '.log';
        $app->filesystem->makeDir($filename);
        $this->assertFalse($app->logger->log($level, 'message'));
    }

}
