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
class FilesystemTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testMakeDir()
    {
        $app = $this->getApp();
        $dir = uniqid();
        $testDir = $this->getTestDir();
        $app->filesystem->makeDir($testDir . $dir);
        $this->assertTrue(is_dir($testDir . $dir));
        $this->setExpectedException('InvalidArgumentException');
        $app->filesystem->makeDir(1);
    }

    /**
     * 
     */
    public function testMakeFileDir()
    {
        $app = $this->getApp();
        $dir = uniqid();
        $file = uniqid() . '.txt';
        $testDir = $this->getTestDir();
        $app->filesystem->makeFileDir($testDir . $dir . '/' . $file);
        $this->assertTrue(is_dir($testDir . $dir));
        $this->setExpectedException('InvalidArgumentException');
        $app->filesystem->makeFileDir(1);
    }

}
