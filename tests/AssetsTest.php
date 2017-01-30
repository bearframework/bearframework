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
class AssetsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testResponse1()
    {
        $app = $this->getApp();
        $filename = $app->config->appDir . '/assets/file.png';
        $this->createSampleFile($filename, 'png');
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
        $this->createSampleFile($filename, 'png');
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
        $this->createDir($app->config->appDir . '/assets/');
        $this->createDir($app->config->addonsDir . '/addon1/assets/');
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
                    $this->createSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === realpath($filename));

                    $url = $app->assets->getUrl($filename, $options);
                    $response = $getAssetResponse($url);
                    $size = $app->images->getSize($response->filename);
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);

                    // File in addon dir
                    $filename = $app->config->addonsDir . '/addon1/assets/logo.' . $fileType;
                    $this->createSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === realpath($filename));

                    $url = $app->assets->getUrl($filename, $options);
                    $response = $getAssetResponse($url);
                    $size = $app->images->getSize($response->filename);
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);

                    // File in data dir
                    $key = 'logo.' . $fileType;
                    $filename = $app->config->dataDir . '/objects/' . $key;
                    $this->createSampleFile($filename, $fileType);

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
                    $size = $app->images->getSize($response->filename);
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
        $this->createDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename = $app->config->appDir . '/assets/file.svg';
        $this->createFile($filename, 'sample-svg-content');
        $content = $app->assets->getContent($filename);
        $this->assertTrue($content === 'sample-svg-content');
        $content = $app->assets->getContent($filename, ['encoding' => 'base64']);
        $this->assertTrue($content === 'c2FtcGxlLXN2Zy1jb250ZW50');
        $content = $app->assets->getContent($filename, ['encoding' => 'data-uri']);
        $this->assertTrue($content === 'data:image/svg+xml,sample-svg-content');
        $content = $app->assets->getContent($filename, ['encoding' => 'data-uri-base64']);
        $this->assertTrue($content === 'data:image/svg+xml;base64,c2FtcGxlLXN2Zy1jb250ZW50');
    }

    /**
     * 
     */
//    public function testAddDirInvalidArguments2()
//    {
//        $app = $this->getApp();
//
//        $this->setExpectedException('InvalidArgumentException');
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
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
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
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($filename, ['width' => 1000000]);
    }

    /**
     * 
     */
    public function testGetUrlInvalidArguments6()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . '/assets/logo.png';
        $this->createSampleFile($filename, 'png');
        $this->setExpectedException('InvalidArgumentException');
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
//        $this->setExpectedException('Exception');
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
//        $this->createSampleFile($filename, 'png');
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
//        $this->createSampleFile($filename, 'png');
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
//        $this->createDir($app->config->appDir . '/assets/');
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
//        $this->createSampleFile($filename, 'png');
//
//        $app->assets->addDir($app->config->appDir . '/assets/');
//
//        $url = $app->assets->getUrl($filename, ['width' => 50, 'height ' => 50]);
//        $this->assertFalse($app->assets->getFilename(substr($url, strlen($app->request->base))));
//    }
}
