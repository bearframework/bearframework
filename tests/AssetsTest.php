<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * 
 */
class AssetsTest extends BearFrameworkTestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlAndGetFilename()
    {
        $app = $this->getApp();

        $fileTypes = ['jpg', 'png', 'gif'];
        $imageOptionsTypes = ['width', 'height', 'both'];
        $sizeModifiers = [0.5, 1, 2];

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
                    $filename = $app->config->appDir . 'assets/logo.' . $fileType;
                    $this->createSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $this->assertTrue($app->assets->getFilename(substr($url, strlen($app->request->base))) === $filename);

                    $url = $app->assets->getUrl($filename, $options);
                    $size = App\Utilities\Graphics::getSize($app->assets->getFilename(substr($url, strlen($app->request->base))));
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);

                    // File in addon dir
                    $filename = $app->config->addonsDir . 'addon1/assets/logo.' . $fileType;
                    $this->createSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $this->assertTrue($app->assets->getFilename(substr($url, strlen($app->request->base))) === $filename);

                    $url = $app->assets->getUrl($filename, $options);
                    $size = App\Utilities\Graphics::getSize($app->assets->getFilename(substr($url, strlen($app->request->base))));
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);

                    // File in data dir
                    $key = 'logo.' . $fileType;
                    $filename = $app->config->dataDir . 'objects/' . $key;
                    $this->createSampleFile($filename, $fileType);

                    $url = $app->assets->getUrl($filename);
                    $app->data->makePublic(['key' => $key]);
                    $this->assertTrue($app->assets->getFilename(substr($url, strlen($app->request->base))) === $filename);
                    $app->data->makePrivate(['key' => $key]);
                    $this->assertFalse($app->assets->getFilename(substr($url, strlen($app->request->base))));

                    $url = $app->assets->getUrl($filename, $options);
                    $app->data->makePublic(['key' => $key]);
                    $size = App\Utilities\Graphics::getSize($app->assets->getFilename(substr($url, strlen($app->request->base))));
                    $this->assertTrue($size[0] === $testImageWidth);
                    $this->assertTrue($size[1] === $testImageHeight);
                }
            }
        }
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions1()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions2()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->appDir . 'assets/logo.png', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions3()
    {
        $app = $this->getApp();
        $app->config->assetsPathPrefix = null;

        $this->setExpectedException('Exception');
        $app->assets->getUrl($app->config->appDir . 'assets/logo.png');
    }

    /**
     * Not in assets dir
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions4()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->appDir . 'logo.png');
    }

    /**
     * Not in assets dir
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions5()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->addonsDir . 'addon1/logo.png');
    }

    /**
     * Not in assets dir
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions6()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl('logo.png');
    }

    /**
     * Zero width
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions7a()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->appDir . 'assets/logo.png', ['width' => 0]);
    }

    /**
     * Too big width
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidOptions7b()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->appDir . 'assets/logo.png', ['width' => 1000000]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidOptions1()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getFilename(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidOptions2()
    {
        $app = $this->getApp();
        $app->config->assetsPathPrefix = null;

        $this->setExpectedException('Exception');
        $app->assets->getFilename('path.png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidOptions3()
    {
        $app = $this->getApp();

        $this->assertFalse($app->assets->getFilename('path.png'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidOptions4a()
    {
        $app = $this->getApp();

        $url = $app->assets->getUrl($app->config->appDir . 'assets/logo.png');
        $path = substr($url, strlen($app->request->base));
        $brokenPath = str_replace('/assets/', '/assets/abc', $path);
        $this->assertFalse($app->assets->getFilename($brokenPath));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidOptions4b()
    {
        $app = $this->getApp();

        $url = $app->assets->getUrl($app->config->appDir . 'assets/logo.png');
        $path = substr($url, strlen($app->request->base));
        $brokenPath = '/assets/abc' . substr($path, strlen('/assets/') + 3);
        $this->assertFalse($app->assets->getFilename($brokenPath));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidOptions4c()
    {
        $app = $this->getApp();

        $url = $app->assets->getUrl($app->config->appDir . 'assets/logo.png');
        $path = substr($url, strlen($app->request->base));
        $brokenPath = '/assets/abcd/logo.png';
        $this->assertFalse($app->assets->getFilename($brokenPath));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidOptions4d()
    {
        $app = $this->getApp();

        $this->assertFalse($app->assets->getFilename('/assets/brokenpath.jpg'));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameMissingDataDir()
    {
        $app = $this->getApp([
            'dataDir' => null
        ]);

        $filename = $app->config->appDir . 'assets/logo.png';
        $this->createSampleFile($filename, 'png');

        $url = $app->assets->getUrl($filename, ['width' => 50, 'height' => 35]);
        $this->setExpectedException('App\InvalidConfigOptionException');
        $app->assets->getFilename(substr($url, strlen($app->request->base)));
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetMimeType1()
    {
        $app = $this->getApp();

        $result = $app->assets->getMimeType('logo.png');
        $this->assertTrue($result === 'image/png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetMimeType2()
    {
        $app = $this->getApp();

        $result = $app->assets->getMimeType('logo.unknown');
        $this->assertTrue($result === null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetMimeTypeInvalidOptions1()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getMimeType(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testMissingExtensionFile()
    {
        $app = $this->getApp();

        $filename = $app->config->appDir . 'assets/logo';
        $this->createSampleFile($filename, 'png');

        $url = $app->assets->getUrl($filename, ['width' => 50, 'height' => 50]);
        $this->assertFalse($app->assets->getFilename(substr($url, strlen($app->request->base))));
    }

}
