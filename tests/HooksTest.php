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
class HooksTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAdd()
    {
        $app = $this->getApp();
        $this->assertFalse($app->hooks->exists('sampleName'));
        $result = '';
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '123';
        });
        $app->hooks->add('sampleName', function() use (&$result) {
            $result .= '456';
        });
        $this->assertTrue($app->hooks->exists('sampleName'));
        $app->hooks->execute('sampleName');
        $this->assertTrue($result === '123456');
    }

}
