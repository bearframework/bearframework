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

}
