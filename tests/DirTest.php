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
        App\Utilities\Dir::make(sys_get_temp_dir() . '/' . $dir);
        $this->assertTrue(is_dir(sys_get_temp_dir() . '/' . $dir));
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Dir::make(1);
    }

}
