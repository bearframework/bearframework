<?php

/*
 * Video embed
 * https://github.com/ivopetkov/video-embed
 * Copyright 2016, Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class AutoloaderTest extends BearFrameworkAutoloaderTestCase
{

    /**
     * 
     */
    public function testClasses()
    {
        $this->assertTrue(class_exists('BearFramework\App\AddonContext'));
        $this->assertTrue(class_exists('BearFramework\App\Addons'));
        $this->assertTrue(class_exists('BearFramework\App\AppContext'));
        $this->assertTrue(class_exists('BearFramework\App\Assets'));
        $this->assertTrue(class_exists('BearFramework\App\Cache'));
        $this->assertTrue(class_exists('BearFramework\App\Classes'));
        $this->assertTrue(class_exists('BearFramework\App\Config'));
        $this->assertTrue(class_exists('BearFramework\App\Container'));
        $this->assertTrue(class_exists('BearFramework\App\Context'));
        $this->assertTrue(class_exists('BearFramework\App\Context\Assets'));
        $this->assertTrue(class_exists('BearFramework\App\Context\Classes'));
        $this->assertTrue(class_exists('BearFramework\App\Data'));
        $this->assertTrue(class_exists('BearFramework\App\Data\DataLockedException'));
        $this->assertTrue(class_exists('BearFramework\App\Filesystem'));
        $this->assertTrue(class_exists('BearFramework\App\Hooks'));
        $this->assertTrue(class_exists('BearFramework\App\Images'));
        $this->assertTrue(class_exists('BearFramework\App\Config\InvalidOptionException'));
        $this->assertTrue(class_exists('BearFramework\App\Logger'));
        $this->assertTrue(class_exists('BearFramework\App\Request'));
        $this->assertTrue(class_exists('BearFramework\App\Request\Path'));
        $this->assertTrue(class_exists('BearFramework\App\Request\Query'));
        $this->assertTrue(class_exists('BearFramework\App\Response'));
        $this->assertTrue(class_exists('BearFramework\App\Response\FileReader'));
        $this->assertTrue(class_exists('BearFramework\App\Response\HTML'));
        $this->assertTrue(class_exists('BearFramework\App\Response\JSON'));
        $this->assertTrue(class_exists('BearFramework\App\Response\NotFound'));
        $this->assertTrue(class_exists('BearFramework\App\Response\PermanentRedirect'));
        $this->assertTrue(class_exists('BearFramework\App\Response\TemporaryRedirect'));
        $this->assertTrue(class_exists('BearFramework\App\Response\TemporaryUnavailable'));
        $this->assertTrue(class_exists('BearFramework\App\Response\Text'));
        $this->assertTrue(class_exists('BearFramework\App\Routes'));
        $this->assertTrue(class_exists('BearFramework\App\Urls'));
        $this->assertTrue(class_exists('BearFramework\Addons'));
        $this->assertTrue(class_exists('BearFramework\App'));
    }

}
