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
            $size = App\Utilities\Graphics::getSize($filename);
            $this->assertTrue($size[0] === 100);
            $this->assertTrue($size[1] === 70);
        }
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument1()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::getSize(1);
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument2()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::getSize('missing/file.png');
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
            $size = App\Utilities\Graphics::resize($sourceFilename, $targetFilename, 50, 35);
            $size = App\Utilities\Graphics::getSize($targetFilename);
            $this->assertTrue($size[0] === 50);
            $this->assertTrue($size[1] === 35);

            $targetFilename = $app->config->appDir . 'assets/newlogo2.' . $fileType;
            $size = App\Utilities\Graphics::resize($sourceFilename, $targetFilename, 35, 45, $fileType);
            $size = App\Utilities\Graphics::getSize($targetFilename);
            $this->assertTrue($size[0] === 35);
            $this->assertTrue($size[1] === 45);
        }
    }

    /**
     * 
     */
    public function testResizeInvalidArgument1()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::resize(1, 'target.png', 100, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument2()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::resize('source.png', 1, 100, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument3()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::resize('source.png', 'target.png', 0, 100);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument4()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::resize('source.png', 'target.png', 100, 0);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument5()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::resize('source.png', 'target.webp', 100, 100, 'webp');
    }

    /**
     * 
     */
    public function testResizeInvalidArgument6()
    {
        $this->setExpectedException('InvalidArgumentException');
        App\Utilities\Graphics::resize('missing/source.png', 'target.png', 100, 100);
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
        App\Utilities\Graphics::resize($filename, 'target.png', 100, 100);
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
        App\Utilities\Graphics::resize($sourceFilename, $targetFilename, 100, 100);
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
        App\Utilities\Graphics::resize($sourceFilename, $targetFilename, 100, 100);
    }

}
