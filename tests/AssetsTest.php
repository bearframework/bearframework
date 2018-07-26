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
class AssetsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testResponse1()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/assets/file.png';
        $this->makeSampleFile($filename, 'png');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $url = $app->assets->getUrl($filename);
        $path = substr($url, strlen($app->request->base));
        $app->request->path->set($path);
        $app->run();
        $this->expectOutputString(file_get_contents($filename));
    }

    /**
     * 
     */
    public function testResponse2()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/assets/missing/file.png';
        $this->makeSampleFile($filename, 'png');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $url = $app->assets->getUrl($filename);
        unlink($filename);
        $path = substr($url, strlen($app->request->base));
        $app->request->path->set($path);
        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * 
     */
    public function testGetUrlAndGetFilename()
    {
        $app = $this->getApp();
        $this->makeDir($app->config->appDir . '/assets/');
        $this->makeDir($app->config->addonsDir . '/addon1/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->addonsDir . '/addon1/assets/');

        $fileTypes = ['jpg', 'png', 'gif'];
        $imageOptionsTypes = ['width', 'height', 'both'];
        $sizeModifiers = [0.5, 1, 2];

        $getAssetResponse = function($url) use ($app) {
            $request = clone($app->request);
            $request->path->set(substr($url, strlen($app->request->base)));
            return $app->assets->getResponse($request);
        };

        foreach ($fileTypes as $fileType) {
            foreach ($imageOptionsTypes as $imageOptionsType) {
                foreach ($sizeModifiers as $sizeModifier) {
                    $testImageWidth = (int) (100 * $sizeModifier);
                    $testImageHeight = (int) (70 * $sizeModifier);
                    if ($imageOptionsType === 'width') {
                        $options = ['width' => $testImageWidth];
                    } elseif ($imageOptionsType === 'height') {
                        $options = ['height' => $testImageHeight];
                    } elseif ($imageOptionsType === 'both') {
                        $options = ['width' => $testImageWidth, 'height' => $testImageHeight];
                    }

                    // File in app dir
                    $filename = $app->config->appDir . '/assets/logo.' . $fileType;
                    $this->makeSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === realpath($filename));

                    $url = $app->assets->getUrl($filename, $options);
                    $response = $getAssetResponse($url);
                    $size = $app->assets->getSize($response->filename);
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);

                    // File in addon dir
                    $filename = $app->config->addonsDir . '/addon1/assets/logo.' . $fileType;
                    $this->makeSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === realpath($filename));

                    $url = $app->assets->getUrl($filename, $options);
                    $response = $getAssetResponse($url);
                    $size = $app->assets->getSize($response->filename);
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);

                    // File in data dir
                    $key = 'logo.' . $fileType;
                    $filename = $app->config->dataDir . '/objects/' . $key;
                    $this->makeSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $app->data->makePublic($key);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === realpath($filename));
                    $app->data->makePrivate($key);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response === null);

                    $url = $app->assets->getUrl($filename, $options);
                    $app->data->makePublic($key);
                    $response = $getAssetResponse($url);
                    $size = $app->assets->getSize($response->filename);
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);
                }
            }
        }
    }

    /**
     * 
     */
    public function testGetContent()
    {
        $app = $this->getApp();
        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename = $app->config->appDir . '/assets/file.svg';
        $this->makeFile($filename, 'sample-svg-content');
        $content = $app->assets->getContent($filename);
        $this->assertTrue($content === 'sample-svg-content');
        $content = $app->assets->getContent($filename, ['encoding' => 'base64']);
        $this->assertTrue($content === 'c2FtcGxlLXN2Zy1jb250ZW50');
        $content = $app->assets->getContent($filename, ['encoding' => 'data-uri']);
        $this->assertTrue($content === 'data:image/svg+xml,sample-svg-content');
        $content = $app->assets->getContent($filename, ['encoding' => 'data-uri-base64']);
        $this->assertTrue($content === 'data:image/svg+xml;base64,c2FtcGxlLXN2Zy1jb250ZW50');
        $this->expectException('InvalidArgumentException');
        $app->assets->getContent($filename, ['encoding' => 'unknown']);
    }

    /**
     * 
     */
    public function testAssetPrepareHook()
    {
        $app = $this->getApp();

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename1 = $app->config->appDir . '/assets/file1.svg';
        $this->makeFile($filename1, 'sample-svg-content-1');
        $filename2 = $app->config->appDir . '/assets/file2.svg';
        $this->makeFile($filename2, 'sample-svg-content-2');

        $app->hooks->add('assetPrepare', function(&$filename, $options) use ($filename2) {
            $filename = $filename2;
        });
        $content = $app->assets->getContent($filename1);
        $this->assertTrue($content === 'sample-svg-content-2');
    }

    /**
     * 
     */
    public function testAssetPreparedHook()
    {
        $app = $this->getApp();

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename1 = $app->config->appDir . '/assets/file1.svg';
        $this->makeFile($filename1, 'sample-svg-content-1');
        $filename2 = $app->config->appDir . '/assets/file2.svg';
        $this->makeFile($filename2, 'sample-svg-content-2');

        $app->hooks->add('assetPrepareDone', function($filename, $options, &$returnValue) use ($filename2) {
            $returnValue = $filename2;
        });
        $content = $app->assets->getContent($filename1);
        $this->assertTrue($content === 'sample-svg-content-2');
    }

    /**
     * 
     */
    public function testAssetUrlCreatedDataHook()
    {
        $app = $this->getApp();

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename = $app->config->appDir . '/assets/file.svg';
        $this->makeFile($filename, 'sample-svg-content');

        $app->hooks->add('assetGetUrlDone', function($filename, $options, &$url) {
            $url = 'http://example.com/file.svg';
        });
        $url = $app->assets->getUrl($filename);
        $this->assertTrue($url === 'http://example.com/file.svg');
    }

    /**
     * 
     */
//    public function testAddDirInvalidArguments2()
//    {
//        $app = $this->getApp();
//
//        $this->expectException('InvalidArgumentException');
//        $app->assets->addDir('missing/dir');
//    }

    /**
     * Zero width
     * 
     */
    public function testGetUrlInvalidArguments5a()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . '/assets/logo.png';
        $this->makeSampleFile($filename, 'png');
        $this->expectException('InvalidArgumentException');
        $app->assets->getUrl($filename, ['width' => 0]);
    }

    /**
     * Too big width
     * 
     */
    public function testGetUrlInvalidArguments5b()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . '/assets/logo.png';
        $this->makeSampleFile($filename, 'png');
        $this->expectException('InvalidArgumentException');
        $app->assets->getUrl($filename, ['width' => 1000000]);
    }

    /**
     * 
     */
    public function testGetUrlInvalidArguments6()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . '/assets/logo.png';
        $this->makeSampleFile($filename, 'png');
        $this->expectException('InvalidArgumentException');
        $app->assets->getUrl($filename);
    }

    /**
     * 
     */
//    public function testGetFilenameInvalidArguments2()
//    {
//        $app = $this->getApp();
//        $app->config->assetsPathPrefix = null;
//
//        $this->expectException('Exception');
//        $app->assets->getFilename('path.png');
//    }

    /**
     * 
     */
//    public function testGetFilenameInvalidArguments3()
//    {
//        $app = $this->getApp();
//
//        $this->assertFalse($app->assets->getFilename('path.png'));
//    }

    /**
     * 
     */
//    public function testGetFilenameInvalidArguments4a()
//    {
//        $app = $this->getApp();
//        $filename = $app->config->appDir . '/assets/logo.png';
//        $this->makeSampleFile($filename, 'png');
//        $app->assets->addDir($app->config->appDir . '/assets/');
//
//        $url = $app->assets->getUrl($filename);
//        $path = substr($url, strlen($app->request->base));
//        $brokenPath = str_replace('/assets/', '/assets/abc', $path);
//        $this->assertFalse($app->assets->getFilename($brokenPath));
//    }

    /**
     * 
     */
//    public function testGetFilenameInvalidArguments4b()
//    {
//        $app = $this->getApp();
//        $filename = $app->config->appDir . '/assets/logo.png';
//        $this->makeSampleFile($filename, 'png');
//        $app->assets->addDir($app->config->appDir . '/assets/');
//
//        $url = $app->assets->getUrl($filename);
//        $path = substr($url, strlen($app->request->base));
//        $brokenPath = '/assets/abc' . substr($path, strlen('/assets/') + 3);
//        $this->assertFalse($app->assets->getFilename($brokenPath));
//    }

    /**
     * 
     */
//    public function testGetFilenameInvalidArguments4c()
//    {
//        $app = $this->getApp();
//        $this->makeDir($app->config->appDir . '/assets/');
//        $app->assets->addDir($app->config->appDir . '/assets/');
//
//        $brokenPath = '/assets/abcd/logo.png';
//        $this->assertFalse($app->assets->getFilename($brokenPath));
//    }

    /**
     * 
     */
//    public function testGetFilenameInvalidArguments4d()
//    {
//        $app = $this->getApp();
//
//        $this->assertFalse($app->assets->getFilename('/assets/brokenpath.jpg'));
//    }

    /**
     * 
     */
    public function testGetMimeType1()
    {
        $app = $this->getApp();

        $result = $app->assets->getMimeType('logo.png');
        $this->assertTrue($result === 'image/png');
    }

    /**
     * 
     */
    public function testGetMimeType2()
    {
        $app = $this->getApp();

        $result = $app->assets->getMimeType('logo.unknown');
        $this->assertTrue($result === null);
    }

    /**
     * 
     */
//    public function testMissingExtensionFile()
//    {
//        $app = $this->getApp();
//
//        $filename = $app->config->appDir . '/assets/logo';
//        $this->makeSampleFile($filename, 'png');
//
//        $app->assets->addDir($app->config->appDir . '/assets/');
//
//        $url = $app->assets->getUrl($filename, ['width' => 50, 'height ' => 50]);
//        $this->assertFalse($app->assets->getFilename(substr($url, strlen($app->request->base))));
//    }

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
            $this->makeSampleFile($filename, $fileType);
            $size = $app->assets->getSize($filename);
            $this->assertTrue($size[0] === 100);
            $this->assertTrue($size[1] === 70);
        }
    }

    /**
     * Return size in assetGetSize
     */
    public function testGetSizeHooks1()
    {
        $app = $this->getApp();
        $app->hooks->add('assetGetSize', function($filename, &$returnValue) {
            if ($filename === 'samplefile.jpg') {
                $returnValue = [200, 100];
            }
        });
        $size = $app->assets->getSize('samplefile.jpg');
        $this->assertTrue($size[0] === 200);
        $this->assertTrue($size[1] === 100);
    }

    /**
     * Return size of other image (alias) in assetGetSize
     */
    public function testGetSizeHooks2()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . '/assets/logo.jpg';
        $this->makeSampleFile($filename, 'jpg');
        $app->hooks->add('assetGetSize', function(&$_filename, &$returnValue) use ($filename) {
            if ($_filename === 'samplefile.jpg') {
                $_filename = $filename;
            }
        });
        $size = $app->assets->getSize('samplefile.jpg');
        $this->assertTrue($size[0] === 100);
        $this->assertTrue($size[1] === 70);
    }

    /**
     * Log assetGetSize
     */
    public function testGetSizeHooks3()
    {
        $app = $this->getApp();

        $imageWidth = null;
        $app->hooks->add('assetGetSizeDone', function($filename, $returnValue) use (&$imageWidth) {
            $imageWidth = $returnValue[0];
        });
        $filename = $app->config->appDir . '/assets/logo.jpg';
        $this->makeSampleFile($filename, 'jpg');
        $app->assets->getSize($filename);
        $this->assertTrue($imageWidth === 100);
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument2()
    {
        $app = $this->getApp();
        $this->expectException('InvalidArgumentException');
        $app->assets->getSize('missing/file.png');
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument3()
    {
        $app = $this->getApp();
        $sourceFilename = $app->config->appDir . '/assets/logo.png';
        $this->makeSampleFile($sourceFilename, 'broken');
        $this->expectException('InvalidArgumentException');
        $app->assets->getSize($sourceFilename);
    }

    /**
     * 
     */
    public function testGetSizeInvalidArgument4()
    {
        $app = $this->getApp();
        $sourceFilename = $app->config->appDir . '/assets/file.mp3';
        $this->makeSampleFile($sourceFilename, 'broken');
        $this->expectException('InvalidArgumentException');
        $app->assets->getSize($sourceFilename);
    }

    /**
     * 
     */
    public function testResize()
    {
        $app = $this->getApp();
        $app->assets->addDir($app->config->appDir . '/assets/');

        $fileTypes = ['jpeg', 'jpg', 'png', 'gif'];
        if (function_exists('imagecreatefromwebp')) {
            $fileTypes[] = 'webp';
        }

        foreach ($fileTypes as $fileType) {
            $sourceFilename = $app->config->appDir . '/assets/file1.' . $fileType;
            $this->makeSampleFile($sourceFilename, $fileType);

            $destinationFilename = $app->config->appDir . '/assets/file1_1.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename, ['width' => 50, 'height' => 35]));
            $size = $app->assets->getSize($destinationFilename);
            $this->assertTrue($size[0] === 50);
            $this->assertTrue($size[1] === 35);

            $destinationFilename = $app->config->appDir . '/assets/file1_2.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename, ['width' => 35, 'height' => 45]));
            $size = $app->assets->getSize($destinationFilename);
            $this->assertTrue($size[0] === 35);
            $this->assertTrue($size[1] === 45);


            $sourceFilename = $app->config->appDir . '/assets/file2.' . $fileType;
            $this->makeSampleFile($sourceFilename, $fileType);
            file_put_contents($sourceFilename, $app->assets->getContent($sourceFilename, ['width' => 44, 'height' => 22]));

            $destinationFilename = $app->config->appDir . '/assets/file2_1.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename, ['width' => 22]));
            $size = $app->assets->getSize($destinationFilename);
            $this->assertTrue($size[0] === 22);
            $this->assertTrue($size[1] === 11);

            $destinationFilename = $app->config->appDir . '/assets/file2_2.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename, ['height' => 11]));
            $size = $app->assets->getSize($destinationFilename);
            $this->assertTrue($size[0] === 22);
            $this->assertTrue($size[1] === 11);

            $destinationFilename = $app->config->appDir . '/assets/file2_3.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename));
            $size = $app->assets->getSize($destinationFilename);
            $this->assertTrue($size[0] === 44);
            $this->assertTrue($size[1] === 22);
        }
    }

    /**
     * 
     */
    public function testResizeInvalidArgument4()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/source.png';
        $this->makeSampleFile($filename, 'png');
        $this->expectException('InvalidArgumentException');
        $app->assets->getContent($filename, ['width' => 0, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument5()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/source.png';
        $this->makeSampleFile($filename, 'png');
        $this->expectException('InvalidArgumentException');
        $app->assets->getContent($filename, ['width' => 100, 'height' => 0]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument7()
    {
        $app = $this->getApp();
        $this->expectException('InvalidArgumentException');
        $app->assets->getContent('missing/source.png', ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument10()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.bmp';
        $destinationFilename = $app->config->appDir . '/assets/newlogo.bmp';
        $this->makeSampleFile($sourceFilename, 'bmp');
        $this->expectException('InvalidArgumentException');
        $app->assets->getContent($sourceFilename, ['width' => 100, 'height' => 100]);
    }

    /**
     * 
     */
    public function testResizeInvalidArgument11()
    {
        $app = $this->getApp();

        $sourceFilename = $app->config->appDir . '/assets/logo.png';
        $destinationFilename = $app->config->appDir . '/assets/newlogo.png';
        $this->makeSampleFile($sourceFilename, 'bmp');
        $this->expectException('InvalidArgumentException');
        $app->assets->getContent($sourceFilename, ['width' => 100, 'height' => 100]);
    }

}
