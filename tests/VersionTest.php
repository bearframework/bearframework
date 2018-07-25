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
class VersionTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testVersion()
    {
        $this->assertTrue(strlen(BearFramework::VERSION) > 0);
    }

}
