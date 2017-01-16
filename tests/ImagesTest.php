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
class ImagesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testGetSize()
    {
        $app = $this->getApp();

        $fileTypes = ['jpg', 'png', 'gif'];
        if (function_exists('imagecreatefromwebp')) {
            $fileTypes[] = 'webp';
        }

        foreach ($fileTypes as $fileType) {
            $filename = $app->config->appDir . '/assets/logo.' . $fileType;
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
    public function testGetSizeInvalidArgument3()
    {
        $app = $this->getApp();
        $sourceFilename = $app->config->appDir . '/assets/logo.png';
        $this->createSampleFile($sourceFilename, 'broken');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->getSize($sourceFilename);
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument4()
    {
        $app = $this->getApp();
        $sourceFilename = $app->config->appDir . '/assets/file.mp3';
        $this->createSampleFile($sourceFilename, 'broken');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->getSize($sourceFilename);
    }

    /**
     * 
     */
    public function testResize()
    {
        $app = $this->getApp();

        $fileTypes = ['jpeg', 'jpg', 'png', 'gif'];
        if (function_exists('imagecreatefromwebp')) {
            $fileTypes[] = 'webp';
        }

        foreach ($fileTypes as $fileType) {
            $sourceFilename = $app->config->appDir . '/assets/file1.' . $fileType;
            $this->createSampleFile($sourceFilename, $fileType);

            $targetFilename = $app->config->appDir . '/assets/file1_1.' . $fileType;
            $size = $app->images->resize($sourceFilename, $targetFilename, ['width' => 50, 'height' => 35]);
            $size = $app->images->getSize($targetFilename);
            $this->assertTrue($size[0] === 50);
            $this->assertTrue($size[1] === 35);

            $targetFilename = $app->config->appDir . '/assets/file1_2.' . $fileType;
            $size = $app->images->resize($sourceFilename, $targetFilename, ['width' => 35, 'height' => 45]);
            $size = $app->images->getSize($targetFilename);
            $this->assertTrue($size[0] === 35);
            $this->assertTrue($size[1] === 45);


            $sourceFilename = $app->config->appDir . '/assets/file2.' . $fileType;
            $this->createSampleFile($sourceFilename, $fileType);
            $size = $app->images->resize($sourceFilename, $sourceFilename, ['width' => 44, 'height' => 22]);

            $targetFilename = $app->config->appDir . '/assets/file2_1.' . $fileType;
            $size = $app->images->resize($sourceFilename, $targetFilename, ['width' => 22]);
            $size = $app->images->getSize($targetFilename);
            $this->assertTrue($size[0] === 22);
            $this->assertTrue($size[1] === 11);

            $targetFilename = $app->config->appDir . '/assets/file2_2.' . $fileType;
            $size = $app->images->resize($sourceFilename, $targetFilename, ['height' => 11]);
            $size = $app->images->getSize($targetFilename);
            $this->assertTrue($size[0] === 22);
            $this->assertTrue($size[1] === 11);

            $targetFilename = $app->config->appDir . '/assets/file2_3.' . $fileType;
            $size = $app->images->resize($sourceFilename, $targetFilename);
            $size = $app->images->getSize($targetFilename);
            $this->assertTrue($size[0] === 44);
            $this->assertTrue($size[1] === 22);
        }
    }

    /**
     * 
     */
    public function testResizeInvalidArgument1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize(1, 'target.png', ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument2()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/source.png';
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($filename, 1, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument3()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/source.png';
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($filename, 'target.png', 2);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument4()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/source.png';
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($filename, 'target.png', ['width' => 0, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument5()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/source.png';
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($filename, 'target.png', ['width' => 100, 'height' => 0]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument6()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/source.png';
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($filename, 'target.bmp', ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument7()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize('missing/source.png', 'target.png', ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument9()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.png';
        $targetFilename = $app->config->appDir . '/assets/missingdir/logo.png';
        $this->createSampleFile($sourceFilename, 'png');
        $this->setExpectedException('Exception');
        $app->images->resize($sourceFilename, $targetFilename, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument10()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.bmp';
        $targetFilename = $app->config->appDir . '/assets/newlogo.bmp';
        $this->createSampleFile($sourceFilename, 'bmp');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($sourceFilename, $targetFilename, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument11()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.png';
        $targetFilename = $app->config->appDir . '/assets/newlogo.png';
        $this->createSampleFile($sourceFilename, 'bmp');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($sourceFilename, $targetFilename, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
//    public function testResizeInvalidArgument12()
//    {
//        $app = $this->getApp();
//
//        $sourceFilename = $app->config->appDir . '/assets/logo.png';
//        $targetFilename = $app->config->appDir . '/assets/newlogo.png';
//        $this->createSampleFile($sourceFilename, 'webp');
//        $this->setExpectedException('InvalidArgumentException');
//        $app->images->resize($sourceFilename, $targetFilename, ['width' => 100, 'height' => 100]);
//    }
}
