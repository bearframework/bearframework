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
class ShortcutsTest extends BearFrameworkTestCase
{

    public function helperFunction()
    {
        return 123;
    }

    /**
     * 
     */
    public function testGet()
    {
        $app = $this->getApp();
        $app->shortcuts->add('var1', function() {
            return $this->helperFunction();
        });
        $this->assertTrue($app->var1 === 123);
    }

    /**
     * 
     */
    public function testDuplicates()
    {
        $app = $this->getApp();
        $app->shortcuts->add('aaa', function() {
            return 1;
        });
        $this->expectException('\Exception');
        $app->shortcuts->add('aaa', function() {
            return 2;
        });
    }

    /**
     * 
     */
    public function testTaken()
    {
        $app = $this->getApp();
        $this->expectException('\Exception');
        $app->shortcuts->add('data', function() {
            return 2;
        });
    }

}
