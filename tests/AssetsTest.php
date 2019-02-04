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
        $this->assertEquals(http_response_code(), 404);
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
        $app->assets->addDir('appdata://assets/');

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
                    $thisImageWidth = (int) (100 * $sizeModifier);
                    $thisImageHeight = (int) (70 * $sizeModifier);
                    if ($imageOptionsType === 'width') {
                        $options = ['width' => $thisImageWidth];
                    } elseif ($imageOptionsType === 'height') {
                        $options = ['height' => $thisImageHeight];
                    } elseif ($imageOptionsType === 'both') {
                        $options = ['width' => $thisImageWidth, 'height' => $thisImageHeight];
                    }

                    // File in app dir
                    $filename = $app->config->appDir . '/assets/logo.' . $fileType;
                    $this->makeSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === str_replace('\\', '/', $filename));

                    $url = $app->assets->getUrl($filename, $options);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($app->assets->getDetails($response->filename, ['width'])['width'] === $thisImageWidth);
                    $this->assertTrue($app->assets->getDetails($response->filename, ['height'])['height'] === $thisImageHeight);

                    // File in addon dir
                    $filename = $app->config->addonsDir . '/addon1/assets/logo.' . $fileType;
                    $this->makeSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === str_replace('\\', '/', $filename));

                    $url = $app->assets->getUrl($filename, $options);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($app->assets->getDetails($response->filename, ['width'])['width'] === $thisImageWidth);
                    $this->assertTrue($app->assets->getDetails($response->filename, ['height'])['height'] === $thisImageHeight);

                    // File in data dir
                    $key = 'assets/logo.' . $fileType;
                    $filename = $app->data->getFilename($key);
                    $this->makeSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($response->filename === str_replace('\\', '/', $filename));

                    $url = $app->assets->getUrl($filename, $options);
                    $response = $getAssetResponse($url);
                    $this->assertTrue($app->assets->getDetails($response->filename, ['width'])['width'] === $thisImageWidth);
                    $this->assertTrue($app->assets->getDetails($response->filename, ['height'])['height'] === $thisImageHeight);
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
    public function testPathPrefix()
    {
        $app = $this->getApp();

        $this->assertEquals($app->assets->pathPrefix, '/assets/');
        $this->assertTrue(isset($app->assets->pathPrefix));

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename = $app->config->appDir . '/assets/file.svg';
        $this->makeFile($filename, 'sample-svg-content');

        $getAssetResponse = function($url) use ($app) {
            $request = clone($app->request);
            $request->path->set(substr($url, strlen($app->request->base)));
            return $app->assets->getResponse($request);
        };

        $url = $app->assets->getUrl($filename);
        $this->assertTrue(strpos($url, 'http://example.com/www/assets/') === 0);
        $response = $getAssetResponse($url);
        $this->assertEquals($response->filename, $filename);

        $url = str_replace('http://example.com/www/assets/', 'http://example.com/www/wrongprefix/', $url);
        $response = $getAssetResponse($url);
        $this->assertTrue($response === null);

        $this->expectException('Exception'); // The pathPrefix is readonly
        $app->assets->pathPrefix = '/new/';
    }

    /**
     * 
     */
    public function testAssetBeforePrepareEvent()
    {
        $app = $this->getApp();

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename1 = $app->config->appDir . '/assets/file1.svg';
        $this->makeFile($filename1, 'sample-svg-content-1');
        $filename2 = $app->config->appDir . '/assets/file2.svg';
        $this->makeFile($filename2, 'sample-svg-content-2');

        $app->assets->addEventListener('beforePrepare', function(\BearFramework\App\Assets\BeforePrepareEvent $event) use ($filename2) {
            $event->filename = $filename2;
        });
        $content = $app->assets->getContent($filename1);
        $this->assertTrue($content === 'sample-svg-content-2');
    }

    /**
     * 
     */
    public function testAssetPrepareEvent()
    {
        $app = $this->getApp();

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename1 = $app->config->appDir . '/assets/file1.svg';
        $this->makeFile($filename1, 'sample-svg-content-1');
        $filename2 = $app->config->appDir . '/assets/file2.svg';
        $this->makeFile($filename2, 'sample-svg-content-2');

        $app->assets->addEventListener('prepare', function(\BearFramework\App\Assets\PrepareEvent $event) use ($filename2) {
            $event->returnValue = $filename2;
        });
        $content = $app->assets->getContent($filename1);
        $this->assertTrue($content === 'sample-svg-content-2');
    }

    /**
     * 
     */
    public function testAssetBeforeGetUrlEvent()
    {
        $app = $this->getApp();

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename = $app->config->appDir . '/assets/file.svg';
        $this->makeFile($filename, 'sample-svg-content');

        $app->assets->addEventListener('beforeGetUrl', function(\BearFramework\App\Assets\BeforeGetUrlEvent $event) {
            $event->returnValue = 'http://example.com/file.svg';
        });
        $url = $app->assets->getUrl($filename);
        $this->assertTrue($url === 'http://example.com/file.svg');
    }

    /**
     * 
     */
    public function testAssetGetUrlEvent()
    {
        $app = $this->getApp();

        $this->makeDir($app->config->appDir . '/assets/');
        $app->assets->addDir($app->config->appDir . '/assets/');
        $filename = $app->config->appDir . '/assets/file.svg';
        $this->makeFile($filename, 'sample-svg-content');

        $app->assets->addEventListener('getUrl', function(\BearFramework\App\Assets\GetUrlEvent $event) {
            $event->url = 'http://example.com/file.svg';
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
    public function testGetDetailsMimeType1()
    {
        $app = $this->getApp();

        $result = $app->assets->getDetails('logo.png', ['mimeType'])['mimeType'];
        $this->assertTrue($result === 'image/png');
    }

    /**
     * 
     */
    public function testGetDetailsMimeType2()
    {
        $app = $this->getApp();

        $result = $app->assets->getDetails('logo.unknown', ['mimeType'])['mimeType'];
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
    public function testGetDetailsSize()
    {
        $app = $this->getApp();

        $fileTypes = ['jpg', 'png', 'gif'];
        if (function_exists('imagecreatefromwebp')) {
            $fileTypes[] = 'webp';
        }

        foreach ($fileTypes as $fileType) {
            $filename = $app->config->appDir . '/assets/logo.' . $fileType;
            $this->makeSampleFile($filename, $fileType);
            $this->assertTrue($app->assets->getDetails($filename, ['width'])['width'] === 100);
            $this->assertTrue($app->assets->getDetails($filename, ['height'])['height'] === 70);
        }
    }

    /**
     * Return size in assetGetDetails
     */
    public function testBeforeGetDetailsEvent1()
    {
        $app = $this->getApp();
        $app->assets->addEventListener('beforeGetDetails', function(\BearFramework\App\Assets\BeforeGetDetailsEvent $event) {
            $event->returnValue = ['width' => 200, 'height' => 100];
        });
        $this->assertTrue($app->assets->getDetails('samplefile.jpg', ['width'])['width'] === 200);
        $this->assertTrue($app->assets->getDetails('samplefile.jpg', ['height'])['height'] === 100);
    }

    /**
     * Return size of other image (alias) in assetGetDetails
     */
    public function testBeforeGetDetailsEvent2()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . '/assets/logo.jpg';
        $this->makeSampleFile($filename, 'jpg');
        $app->assets->addEventListener('beforeGetDetails', function(\BearFramework\App\Assets\BeforeGetDetailsEvent $event)use ($filename) {
            $event->filename = $filename;
        });
        $this->assertTrue($app->assets->getDetails('samplefile.jpg', ['width'])['width'] === 100);
        $this->assertTrue($app->assets->getDetails('samplefile.jpg', ['height'])['height'] === 70);
    }

    /**
     * Log assetGetDetails
     */
    public function testGetDetailsEvent()
    {
        $app = $this->getApp();

        $imageWidth = null;
        $app->assets->addEventListener('getDetails', function(\BearFramework\App\Assets\GetDetailsEvent $event) use (&$imageWidth) {
            $imageWidth = $event->returnValue['width'];
        });
        $filename = $app->config->appDir . '/assets/logo.jpg';
        $this->makeSampleFile($filename, 'jpg');
        $app->assets->getDetails($filename, ['width']);
        $this->assertTrue($imageWidth === 100);
    }

    /**
     * 
     */
    public function testGetDetails()
    {
        $app = $this->getApp();
        $result = $app->assets->getDetails('missing/file.png', ['mimeType', 'size', 'width', 'height']);
        $this->assertTrue($result['mimeType'] === 'image/png');
        $this->assertTrue($result['size'] === null);
        $this->assertTrue($result['width'] === null);
        $this->assertTrue($result['height'] === null);

        $filename = $app->config->appDir . '/assets/logo.png';
        $this->makeSampleFile($filename, 'broken');
        $result = $app->assets->getDetails($filename, ['mimeType', 'size', 'width', 'height']);
        $this->assertTrue($result['mimeType'] === 'image/png');
        $this->assertTrue($result['size'] === 4);
        $this->assertTrue($result['width'] === null);
        $this->assertTrue($result['height'] === null);

        $filename = $app->config->appDir . '/assets/file.unknown';
        $this->makeSampleFile($filename, 'broken');
        $result = $app->assets->getDetails($filename, ['mimeType', 'size', 'width', 'height']);
        $this->assertTrue($result['mimeType'] === null);
        $this->assertTrue($result['size'] === 4);
        $this->assertTrue($result['width'] === null);
        $this->assertTrue($result['height'] === null);
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
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['width'])['width'] === 50);
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['height'])['height'] === 35);

            $destinationFilename = $app->config->appDir . '/assets/file1_2.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename, ['width' => 35, 'height' => 45]));
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['width'])['width'] === 35);
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['height'])['height'] === 45);


            $sourceFilename = $app->config->appDir . '/assets/file2.' . $fileType;
            $this->makeSampleFile($sourceFilename, $fileType);
            file_put_contents($sourceFilename, $app->assets->getContent($sourceFilename, ['width' => 44, 'height' => 22]));

            $destinationFilename = $app->config->appDir . '/assets/file2_1.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename, ['width' => 22]));
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['width'])['width'] === 22);
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['height'])['height'] === 11);

            $destinationFilename = $app->config->appDir . '/assets/file2_2.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename, ['height' => 11]));
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['width'])['width'] === 22);
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['height'])['height'] === 11);

            $destinationFilename = $app->config->appDir . '/assets/file2_3.' . $fileType;
            file_put_contents($destinationFilename, $app->assets->getContent($sourceFilename));
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['width'])['width'] === 44);
            $this->assertTrue($app->assets->getDetails($destinationFilename, ['height'])['height'] === 22);
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
