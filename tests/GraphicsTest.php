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
class GraphicsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testGetSize()
    {
        $app = $this->getApp();

        $fileTypes = ['jpg', 'png', 'gif'];

        foreach ($fileTypes as $fileType) {
            $filename = $app->config->appDir . 'assets/logo.' . $fileType;
            $this->createSampleFile($filename, $fileType);
            $size = $app->images->getSize($filename);
            $this->assertTrue($size[0] === 100);
            $this->assertTrue($size[1] === 70);
        }
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->getSize(1);
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->getSize('missing/file.png');
    }

    /**
     * 
     */
    public function testResize()
    {
        $app = $this->getApp();

        $fileTypes = ['jpeg', 'jpg', 'png', 'gif'];

        foreach ($fileTypes as $fileType) {
            $sourceFilename = $app->config->appDir . 'assets/logo.' . $fileType;
            $this->createSampleFile($sourceFilename, $fileType);

            $targetFilename = $app->config->appDir . 'assets/newlogo.' . $fileType;
            $size = $app->images->resize($sourceFilename, $targetFilename, 50, 35);
            $size = $app->images->getSize($targetFilename);
            $this->assertTrue($size[0] === 50);
            $this->assertTrue($size[1] === 35);

            $targetFilename = $app->config->appDir . 'assets/newlogo2.' . $fileType;
            $size = $app->images->resize($sourceFilename, $targetFilename, 35, 45, $fileType);
            $size = $app->images->getSize($targetFilename);
            $this->assertTrue($size[0] === 35);
            $this->assertTrue($size[1] === 45);
        }
    }

    /**
     * 
     */
    public function testResizeInvalidArgument1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize(1, 'target.png', 100, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize('source.png', 1, 100, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize('source.png', 'target.png', 0, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument4()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize('source.png', 'target.png', 100, 0);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument5()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize('source.png', 'target.webp', 100, 100, 'webp');
    }

    /**
     * 
     */
    public function testResizeInvalidArgument6()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize('missing/source.png', 'target.png', 100, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument7()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . 'assets/logo.txt';
        $this->createFile($filename, 'text');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($filename, 'target.png', 100, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument8()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . 'assets/logo.png';
        $targetFilename = $app->config->appDir . 'assets/missingdir/logo.png';
        $this->createSampleFile($sourceFilename, 'png');
        $this->setExpectedException('Exception');
        $app->images->resize($sourceFilename, $targetFilename, 100, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument9()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . 'assets/logo.webp';
        $targetFilename = $app->config->appDir . 'assets/newlogo.webp';
        $this->createSampleFile($sourceFilename, 'webp');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($sourceFilename, $targetFilename, 100, 100);
    }

}
