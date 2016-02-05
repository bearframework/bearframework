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
class FileTest extends BearFrameworkTestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testMakeDir()
    {
        $dir = uniqid();
        $file = uniqid() . '.txt';
        $testDir = $this->getTestDir();
        App\Utilities\File::makeDir($testDir . $dir . '/' . $file);
        $this->assertTrue(is_dir($testDir . $dir));
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\File::makeDir(1);
    }

}
