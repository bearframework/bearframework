<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class ClassesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAdd()
    {
        $app = $this->getApp();
        $this->createFile($app->config->appDir . '/tempClass1.php', '<?php class TempClass1{}');
        $this->assertFalse($app->classes->exists('TempClass1'));
        $app->classes->add('TempClass1', $app->config->appDir . '/tempClass1.php');
        $this->assertTrue($app->classes->exists('TempClass1'));
        $this->assertTrue(class_exists('TempClass1'));
    }

}
