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
class ContextTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAppContext()
    {

        $app = $this->getApp();
        $app->request->base = 'http://example.com/www';

        $this->createFile($app->config->appDir . '/index.php', '<?php ');
        $this->createFile($app->config->appDir . '/class1.php', '<?php class TempClass1{}');

        $context = $app->context->get($app->config->appDir);
        $this->assertTrue(isset($context->assets));
        $this->assertTrue(isset($context->classes));

        $context->classes->add('TempClass1', 'class1.php');
        $this->assertTrue(class_exists('TempClass1'));

        $this->createSampleFile($app->config->appDir . '/assets/logo.png', 'png');
        $context->assets->addDir('assets/');

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);

        $filename = 'assets/file.svg';
        $this->createFile($context->dir . '/' . $filename, 'sample-svg-content');
        $content = $context->assets->getContent($filename);
        $this->assertTrue($content === 'sample-svg-content');
        $content = $context->assets->getContent($filename, ['encoding' => 'base64']);
        $this->assertTrue($content === 'c2FtcGxlLXN2Zy1jb250ZW50');
        $content = $context->assets->getContent($filename, ['encoding' => 'data-uri']);
        $this->assertTrue($content === 'data:image/svg+xml,sample-svg-content');
        $content = $context->assets->getContent($filename, ['encoding' => 'data-uri-base64']);
        $this->assertTrue($content === 'data:image/svg+xml;base64,c2FtcGxlLXN2Zy1jb250ZW50');
    }

    /**
     * 
     */
    public function testAddonContext()
    {
        $app = $this->getApp();
        $addonDir = $app->config->addonsDir . '/tempaddon' . uniqid() . '/';
        $app->request->base = 'http://example.com/www';

        $this->createFile($addonDir . 'index.php', '<?php ');
        $this->createFile($addonDir . 'class1.php', '<?php class TempClass1{}');

        BearFramework\Addons::register('tempaddon', $addonDir);
        $app->addons->add('tempaddon', ['option1' => 5]);

        $context = $app->context->get($addonDir);
        $this->assertTrue(isset($context->assets));
        $this->assertTrue(isset($context->classes));

        $context->classes->add('TempClass1', 'class1.php');
        $this->assertTrue(class_exists('TempClass1'));

        $this->createSampleFile($addonDir . 'assets/logo.png', 'png');
        $context->assets->addDir('assets/');

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);

        $filename = 'assets/file.svg';
        $this->createFile($context->dir . '/' . $filename, 'sample-svg-content');
        $content = $context->assets->getContent($filename);
        $this->assertTrue($content === 'sample-svg-content');
        $content = $context->assets->getContent($filename, ['encoding' => 'base64']);
        $this->assertTrue($content === 'c2FtcGxlLXN2Zy1jb250ZW50');
        $content = $context->assets->getContent($filename, ['encoding' => 'data-uri']);
        $this->assertTrue($content === 'data:image/svg+xml,sample-svg-content');
        $content = $context->assets->getContent($filename, ['encoding' => 'data-uri-base64']);
        $this->assertTrue($content === 'data:image/svg+xml;base64,c2FtcGxlLXN2Zy1jb250ZW50');
    }

    /**
     * 
     */
    public function testUnknownContext()
    {
        $app = $this->getApp();
        $addonDir = $app->config->addonsDir . '/tempaddong' . uniqid() . '/';
        $this->createFile($addonDir . 'index.php', '<?php ');
        // Addon is not added
        $this->setExpectedException('Exception');
        $app->context->get($addonDir);
    }

    /**
     * 
     */
    public function testContextInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Context('missing/dir');
    }

    /**
     * 
     */
    public function testContextAssetsInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Context\Assets('missing/dir');
    }

    /**
     * 
     */
    public function testContextAssetsInvalidArguments5()
    {
        $app = $this->getApp();
        $this->createDir($app->config->appDir . '/dir');
        $contextAssets = new \BearFramework\App\Context\Assets($app->config->appDir . '/dir');
        $this->setExpectedException('InvalidArgumentException');
        $contextAssets->getUrl('missing/file.png');
    }

    /**
     * 
     */
    public function testContextClassesInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Context\Classes('missing/dir');
    }

    /**
     * 
     */
    public function testContextClassesInvalidArguments3()
    {
        $app = $this->getApp();
        $this->createDir($app->config->appDir . '/dir');
        $contextClasses = new \BearFramework\App\Context\Classes($app->config->appDir . '/dir');
        $this->setExpectedException('InvalidArgumentException');
        $contextClasses->add(1, 'testclass.php');
    }

    /**
     * 
     */
    public function testContextClassesInvalidArguments5()
    {
        $app = $this->getApp();
        $this->createDir($app->config->appDir . '/dir');
        $contextClasses = new \BearFramework\App\Context\Classes($app->config->appDir . '/dir');
        $this->setExpectedException('InvalidArgumentException');
        $contextClasses->add('TestClass', 'testclass.php');
    }

}
