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
     * Return size in imageGetSize
     */
    public function testGetSizeHooks1()
    {
        $app = $this->getApp();
        $app->hooks->add('imageGetSize', function($filename, &$returnValue) {
            if ($filename === 'samplefile.jpg') {
                $returnValue = [200, 100];
            }
        });
        $size = $app->images->getSize('samplefile.jpg');
        $this->assertTrue($size[0] === 200);
        $this->assertTrue($size[1] === 100);
    }

    /**
     * Return size of other image (alias) in imageGetSize
     */
    public function testGetSizeHooks2()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . '/assets/logo.jpg';
        $this->createSampleFile($filename, 'jpg');
        $app->hooks->add('imageGetSize', function(&$_filename, &$returnValue) use ($filename) {
            if ($_filename === 'samplefile.jpg') {
                $_filename = $filename;
            }
        });
        $size = $app->images->getSize('samplefile.jpg');
        $this->assertTrue($size[0] === 100);
        $this->assertTrue($size[1] === 70);
    }

    /**
     * Log imageGetSize
     */
    public function testGetSizeHooks3()
    {
        $app = $this->getApp();

        $imageWidth = null;
        $app->hooks->add('imageGetSizeDone', function($filename, $returnValue) use (&$imageWidth) {
            $imageWidth = $returnValue[0];
        });
        $filename = $app->config->appDir . '/assets/logo.jpg';
        $this->createSampleFile($filename, 'jpg');
        $app->images->getSize($filename);
        $this->assertTrue($imageWidth === 100);
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

            $destinationFilename = $app->config->appDir . '/assets/file1_1.' . $fileType;
            $size = $app->images->resize($sourceFilename, $destinationFilename, ['width' => 50, 'height' => 35]);
            $size = $app->images->getSize($destinationFilename);
            $this->assertTrue($size[0] === 50);
            $this->assertTrue($size[1] === 35);

            $destinationFilename = $app->config->appDir . '/assets/file1_2.' . $fileType;
            $size = $app->images->resize($sourceFilename, $destinationFilename, ['width' => 35, 'height' => 45]);
            $size = $app->images->getSize($destinationFilename);
            $this->assertTrue($size[0] === 35);
            $this->assertTrue($size[1] === 45);


            $sourceFilename = $app->config->appDir . '/assets/file2.' . $fileType;
            $this->createSampleFile($sourceFilename, $fileType);
            $size = $app->images->resize($sourceFilename, $sourceFilename, ['width' => 44, 'height' => 22]);

            $destinationFilename = $app->config->appDir . '/assets/file2_1.' . $fileType;
            $size = $app->images->resize($sourceFilename, $destinationFilename, ['width' => 22]);
            $size = $app->images->getSize($destinationFilename);
            $this->assertTrue($size[0] === 22);
            $this->assertTrue($size[1] === 11);

            $destinationFilename = $app->config->appDir . '/assets/file2_2.' . $fileType;
            $size = $app->images->resize($sourceFilename, $destinationFilename, ['height' => 11]);
            $size = $app->images->getSize($destinationFilename);
            $this->assertTrue($size[0] === 22);
            $this->assertTrue($size[1] === 11);

            $destinationFilename = $app->config->appDir . '/assets/file2_3.' . $fileType;
            $size = $app->images->resize($sourceFilename, $destinationFilename);
            $size = $app->images->getSize($destinationFilename);
            $this->assertTrue($size[0] === 44);
            $this->assertTrue($size[1] === 22);
        }
    }

    /**
     * Custom resize in imageResize
     */
    public function testResizeHooks1()
    {
        $app = $this->getApp();
        // it's fake resize, just copy
        $app->hooks->add('imageResize', function(string &$sourceFilename, string &$destinationFilename, array &$options, bool &$done) {
            copy($sourceFilename, $destinationFilename);
            $done = true;
        });
        $sourceFilename = $app->config->appDir . '/assets/logo.jpg';
        $destinationFilename = $app->config->appDir . '/assets/logo_resized.jpg';
        $this->createSampleFile($sourceFilename, 'jpg');
        $app->images->resize($sourceFilename, $destinationFilename, ['width' => 50]);
        $size = $app->images->getSize($destinationFilename);
        $this->assertTrue($size[0] === 100);
        $this->assertTrue($size[1] === 70);
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
        $app->images->resize($filename, 'destination.png', ['width' => 0, 'height' => 100]);
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
        $app->images->resize($filename, 'destination.png', ['width' => 100, 'height' => 0]);
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
        $app->images->resize($filename, 'destination.bmp', ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument7()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize('missing/source.png', 'destination.png', ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument9()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.png';
        $destinationFilename = $app->config->appDir . '/assets/missingdir/logo.png';
        $this->createSampleFile($sourceFilename, 'png');
        $this->setExpectedException('Exception');
        $app->images->resize($sourceFilename, $destinationFilename, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument10()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.bmp';
        $destinationFilename = $app->config->appDir . '/assets/newlogo.bmp';
        $this->createSampleFile($sourceFilename, 'bmp');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($sourceFilename, $destinationFilename, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument11()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.png';
        $destinationFilename = $app->config->appDir . '/assets/newlogo.png';
        $this->createSampleFile($sourceFilename, 'bmp');
        $this->setExpectedException('InvalidArgumentException');
        $app->images->resize($sourceFilename, $destinationFilename, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
//    public function testResizeInvalidArgument12()
//    {
//        $app = $this->getApp();
//
//        $sourceFilename = $app->config->appDir . '/assets/logo.png';
//        $destinationFilename = $app->config->appDir . '/assets/newlogo.png';
//        $this->createSampleFile($sourceFilename, 'webp');
//        $this->setExpectedException('InvalidArgumentException');
//        $app->images->resize($sourceFilename, $destinationFilename, ['width' => 100, 'height' => 100]);
//    }
}
