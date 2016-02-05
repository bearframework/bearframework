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
class DirTest extends BearFrameworkTestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testMakeDir()
    {
        $dir = uniqid();
        $testDir = $this->getTestDir();
        App\Utilities\Dir::make($testDir . $dir);
        $this->assertTrue(is_dir($testDir . $dir));
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Dir::make(1);
    }

}
