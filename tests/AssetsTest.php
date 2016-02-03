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
class AssetsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testGetUrl()
    {
        $app = new App([
            'appDir' => sys_get_temp_dir() . '/unittests/app/',
            'addonsDir' => sys_get_temp_dir() . '/unittests/addons/',
            'dataDir' => sys_get_temp_dir() . '/unittests/data/'
        ]);
        $app->request->base = 'http://example.com';

        $url = $app->assets->getUrl($app->config->appDir . 'assets/logo.png', ['width' => 200, 'height' => 200]);
        $this->assertTrue(strpos($url, 'http://example.com/assets/') === 0);

        $url = $app->assets->getUrl($app->config->addonsDir . 'addon1/assets/logo.png', ['width' => 200, 'height' => 200]);
        $this->assertTrue(strpos($url, 'http://example.com/assets/') === 0);

        $url = $app->assets->getUrl($app->config->dataDir . 'objects/logo.png', ['width' => 200, 'height' => 200]);
        $this->assertTrue(strpos($url, 'http://example.com/assets/') === 0);

        $url = $app->assets->getUrl($app->config->appDir . 'assets/logo.png', ['width' => 0, 'height' => 100001]);
        $this->assertTrue(strpos($url, 'http://example.com/assets/') === 0);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidArguments1()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidArguments2()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->appDir . 'assets/logo.png', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidArguments3()
    {
        $app = new App([
            'assetsPathPrefix' => null
        ]);

        $this->setExpectedException('Exception');
        $app->assets->getUrl($app->config->appDir . 'assets/logo.png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidArguments4()
    {
        $app = new App([
            'appDir' => sys_get_temp_dir() . '/unittests/app/'
        ]);

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->appDir . 'logo.png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidArguments5()
    {
        $app = new App([
            'addonsDir' => sys_get_temp_dir() . '/unittests/addons/'
        ]);

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl($app->config->addonsDir . 'addon1/logo.png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetUrlInvalidArguments6()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getUrl('logo.png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilename()
    {
        $app = new App([
            'appDir' => sys_get_temp_dir() . '/unittests/app/',
            'addonsDir' => sys_get_temp_dir() . '/unittests/addons/',
            'dataDir' => sys_get_temp_dir() . '/unittests/data/'
        ]);
        $app->request->base = 'http://example.com';

        $sampleFileContent = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAIAAAACAgMAAAAP2OW3AAAADFBMVEX/AABQOOBo4Tjx6iYiPN0wAAAADElEQVR42mMQYNgAAADkAMEZVTv7AAAAAElFTkSuQmCC');

        $filename = $app->config->appDir . 'assets/logo' . uniqid() . '.png';
        App\Utilities\File::makeDir($filename);
        file_put_contents($filename, $sampleFileContent);

        $url = $app->assets->getUrl($filename);
        $this->assertTrue($app->assets->getFilename(substr($url, strlen($app->request->base))) === $filename);

//        $url = $app->assets->getUrl($filename, ['width' => 1, 'height' => 1]);
//        $size = App\Utilities\Graphics::getSize($app->assets->getFilename(substr($url, strlen($app->request->base))));
//        $this->assertTrue($size[0] === 1);
//        $this->assertTrue($size[1] === 1);

        $filename = $app->config->addonsDir . 'addon1/assets/logo' . uniqid() . '.png';
        App\Utilities\File::makeDir($filename);
        file_put_contents($filename, $sampleFileContent);

        $url = $app->assets->getUrl($filename);
        $this->assertTrue($app->assets->getFilename(substr($url, strlen($app->request->base))) === $filename);

//        $url = $app->assets->getUrl($filename, ['width' => 1, 'height' => 1]);
//        $size = App\Utilities\Graphics::getSize($app->assets->getFilename(substr($url, strlen($app->request->base))));
//        $this->assertTrue($size[0] === 1);
//        $this->assertTrue($size[1] === 1);

        $key = 'logo' . uniqid() . '.png';
        $filename = $app->config->dataDir . 'objects/' . $key;
        App\Utilities\File::makeDir($filename);
        file_put_contents($filename, $sampleFileContent);

        $url = $app->assets->getUrl($filename);
        $app->data->makePublic(['key' => $key]);
        $this->assertTrue($app->assets->getFilename(substr($url, strlen($app->request->base))) === $filename);
        $app->data->makePrivate(['key' => $key]);
        $this->assertTrue($app->assets->getFilename(substr($url, strlen($app->request->base))) === false);

//        $url = $app->assets->getUrl($filename, ['width' => 1, 'height' => 1]);
//        $app->data->makePublic(['key' => $key]);
//        $size = App\Utilities\Graphics::getSize($app->assets->getFilename(substr($url, strlen($app->request->base))));
//        $this->assertTrue($size[0] === 1);
//        $this->assertTrue($size[1] === 1);

        $this->assertTrue($app->assets->getFilename('/assets/missing.png') === false);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidArguments1()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getFilename(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidArguments2()
    {
        $app = new App(['assetsPathPrefix' => null]);

        $this->setExpectedException('Exception');
        $app->assets->getFilename('path.png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidArguments3()
    {
        $app = new App();

        $this->assertTrue($app->assets->getFilename('path.png') === false);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidArguments4a()
    {
        $app = new App([
            'appDir' => sys_get_temp_dir() . '/unittests/app/'
        ]);
        $app->request->base = 'http://example.com/www';

        $url = $app->assets->getUrl($app->config->appDir . 'assets/logo.png');
        $path = substr($url, strlen($app->request->base));
        $brokenPath = str_replace('/assets/', '/assets/abc', $path);
        $this->assertTrue($app->assets->getFilename($brokenPath) === false);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetFilenameInvalidArguments4b()
    {
        $app = new App([
            'appDir' => sys_get_temp_dir() . '/unittests/app/'
        ]);
        $app->request->base = 'http://example.com/www';

        $url = $app->assets->getUrl($app->config->appDir . 'assets/logo.png');
        $path = substr($url, strlen($app->request->base));
        $brokenPath = '/assets/abc' . substr($path, strlen('/assets/') + 3);
        $this->assertTrue($app->assets->getFilename($brokenPath) === false);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetMimeType1()
    {
        $app = new App();

        $result = $app->assets->getMimeType('logo.png');
        $this->assertTrue($result === 'image/png');
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetMimeType2()
    {
        $app = new App();

        $result = $app->assets->getMimeType('logo.unknown');
        $this->assertTrue($result === null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testGetMimeTypeInvalidArguments1()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->assets->getMimeType(1);
    }

}
