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
class FileTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testMakeDir()
    {
        $dir = uniqid();
        $file = uniqid() . '.txt';
        App\Utilities\File::makeDir(sys_get_temp_dir() . '/' . $dir . '/' . $file);
        $this->assertTrue(is_dir(sys_get_temp_dir() . '/' . $dir));
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\File::makeDir(1);
    }

}
