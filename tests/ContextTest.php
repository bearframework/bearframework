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

        $this->makeFile($app->config->appDir . '/index.php', '<?php ');
        $this->makeFile($app->config->appDir . '/class1.php', '<?php class TempClass1{}');

        $context = $app->context->get($app->config->appDir . '/index.php');
        $this->assertTrue($context->dir === $app->config->appDir);
        $this->assertTrue(isset($context->assets));
        $this->assertTrue(isset($context->classes));

        $context = $app->context->get($app->config->appDir . '/index.php'); // test cache hit
        $this->assertTrue($context->dir === $app->config->appDir);

        $context = $app->context->get($app->config->appDir . '/index2.php'); // test cache hit
        $this->assertTrue($context->dir === $app->config->appDir);

        $context->classes->add('TempClass1', 'class1.php');
        $this->assertTrue(class_exists('TempClass1'));

        $this->makeSampleFile($app->config->appDir . '/assets/logo.png', 'png');
        $context->assets->addDir('assets/');

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);

        $this->assertEquals($context->assets->getDetails('assets/logo.png', ['width', 'height']), [
            'width' => 100,
            'height' => 70
        ]);

        $filename = 'assets/file.svg';
        $this->makeFile($context->dir . '/' . $filename, 'sample-svg-content');
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
        $addonDir = $app->config->addonsDir . '/tempaddon' . uniqid();
        $app->request->base = 'http://example.com/www';

        $this->makeFile($addonDir . '/index.php', '<?php ');
        $this->makeFile($addonDir . '/class1.php', '<?php class TempClass1{}');

        BearFramework\Addons::register('tempaddon', $addonDir);
        $app->addons->add('tempaddon', ['option1' => 5]);

        $context = $app->context->get($addonDir . '/index.php');
        $this->assertTrue($context->dir === $addonDir);
        $this->assertTrue(isset($context->assets));
        $this->assertTrue(isset($context->classes));

        $context->classes->add('TempClass1', 'class1.php');
        $this->assertTrue(class_exists('TempClass1'));

        $this->makeSampleFile($addonDir . '/assets/logo.png', 'png');
        $context->assets->addDir('assets/');

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);
    }

    /**
     * 
     */
    public function testAutoDetectContext()
    {
        $app = $this->getApp();
        $addonDir = $app->config->addonsDir . '/tempaddon' . uniqid();

        $this->makeFile($addonDir . '/index.php', '<?php
            
$app = BearFramework\App::get();
$context = $app->context->get();
$app->config->valueToCheck = $context->dir;
');

        BearFramework\Addons::register('tempaddon', $addonDir);
        $app->addons->add('tempaddon');
        $this->assertTrue($app->config->valueToCheck === $addonDir);
    }

    /**
     * 
     */
    public function testAddonContextInAnotherAddonContext()
    {
        $app = $this->getApp();

        $addon1Dir = $app->config->addonsDir . '/addon1';
        $this->makeFile($addon1Dir . '/index.php', '<?php ');
        BearFramework\Addons::register('addon1', $addon1Dir);
        $app->addons->add('addon1');

        $addon2Dir = $addon1Dir . 'vendor/addon2';
        $this->makeFile($addon2Dir . '/index.php', '<?php ');
        BearFramework\Addons::register('addon2', $addon2Dir);
        $app->addons->add('addon2');

        $context1 = $app->context->get($addon1Dir . '/index.php');
        $this->assertTrue($context1->dir === $addon1Dir);

        $context2 = $app->context->get($addon2Dir . '/index.php');
        $this->assertTrue($context2->dir === $addon2Dir);
    }

    /**
     * 
     */
    public function testAddonContextWithNoAppContext()
    {
        $app = $this->getApp(['appIndexContent' => null]);
        $addonDir = $app->config->addonsDir . '/tempaddon' . uniqid();

        $this->makeFile($addonDir . '/index.php', '<?php ');

        BearFramework\Addons::register('tempaddon', $addonDir);
        $app->addons->add('tempaddon');

        $context = $app->context->get($addonDir . '/index.php');
        $this->assertTrue($context->dir === $addonDir);

        $context = $app->context->get($addonDir);
        $this->assertTrue($context->dir === $addonDir);
    }

    /**
     * 
     */
    public function testUnknownContext()
    {
        $app = $this->getApp();
        $addonDir = $app->config->addonsDir . '/tempaddong' . uniqid() . '/';
        $this->makeFile($addonDir . 'index.php', '<?php ');
        // Addon is not added
        $this->expectException('Exception');
        $app->context->get($addonDir);
    }

}
