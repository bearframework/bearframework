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

        $context = $app->context->get($app->config->appDir . DIRECTORY_SEPARATOR . 'index.php');
        $this->assertTrue($context->dir === $app->config->appDir);
        $this->assertTrue(isset($context->assets));
        $this->assertTrue(isset($context->classes));

        $context = $app->context->get($app->config->appDir . DIRECTORY_SEPARATOR . 'index.php'); // test cache hit
        $this->assertTrue($context->dir === $app->config->appDir);

        $context = $app->context->get($app->config->appDir . DIRECTORY_SEPARATOR . 'index2.php'); // test cache hit
        $this->assertTrue($context->dir === $app->config->appDir);

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
        $addonDir = $app->config->addonsDir . DIRECTORY_SEPARATOR . 'tempaddon' . uniqid() . DIRECTORY_SEPARATOR;
        $app->request->base = 'http://example.com/www';

        $this->createFile($addonDir . 'index.php', '<?php ');
        $this->createFile($addonDir . 'class1.php', '<?php class TempClass1{}');

        BearFramework\Addons::register('tempaddon', $addonDir);
        $app->addons->add('tempaddon', ['option1' => 5]);

        $context = $app->context->get($addonDir . 'index.php');
        $this->assertTrue($context->dir === rtrim($addonDir, DIRECTORY_SEPARATOR));
        $this->assertTrue(isset($context->assets));
        $this->assertTrue(isset($context->classes));

        $context->classes->add('TempClass1', 'class1.php');
        $this->assertTrue(class_exists('TempClass1'));

        $this->createSampleFile($addonDir . 'assets/logo.png', 'png');
        $context->assets->addDir('assets/');

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);

//        $filename = 'assets/file.svg';
//        $this->createFile($context->dir . '/' . $filename, 'sample-svg-content');
//        $content = $context->assets->getContent($filename);
//        $this->assertTrue($content === 'sample-svg-content');
//        $content = $context->assets->getContent($filename, ['encoding' => 'base64']);
//        $this->assertTrue($content === 'c2FtcGxlLXN2Zy1jb250ZW50');
//        $content = $context->assets->getContent($filename, ['encoding' => 'data-uri']);
//        $this->assertTrue($content === 'data:image/svg+xml,sample-svg-content');
//        $content = $context->assets->getContent($filename, ['encoding' => 'data-uri-base64']);
//        $this->assertTrue($content === 'data:image/svg+xml;base64,c2FtcGxlLXN2Zy1jb250ZW50');
    }

    /**
     * 
     */
    public function testAddonContextWithNoAppContext()
    {
        $app = $this->getApp(['appDir' => null]);
        $addonDir = $app->config->addonsDir . DIRECTORY_SEPARATOR . 'tempaddon' . uniqid() . DIRECTORY_SEPARATOR;

        $this->createFile($addonDir . 'index.php', '<?php ');

        BearFramework\Addons::register('tempaddon', $addonDir);
        $app->addons->add('tempaddon');

        $context = $app->context->get($addonDir . 'index.php');
        $this->assertTrue($context->dir === rtrim($addonDir, DIRECTORY_SEPARATOR));

        $context = $app->context->get($addonDir);
        $this->assertTrue($context->dir === rtrim($addonDir, DIRECTORY_SEPARATOR));
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

}
