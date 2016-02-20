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

        $this->createFile($app->config->appDir . 'index.php', '<?php ');
        $this->createFile($app->config->appDir . 'class1.php', '<?php class TempClass1{}');

        $context = $app->getContext($app->config->appDir);

        $context->classes->add('TempClass1', 'class1.php');
        $this->assertTrue(class_exists('TempClass1'));

        $context->assets->addDir('assets/');

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);
    }

    /**
     * 
     */
    public function testAddonContext()
    {
        $app = $this->getApp();
        $addonDir = $app->config->addonsDir . 'tempaddon' . uniqid() . '/';
        $app->request->base = 'http://example.com/www';

        $this->createFile($addonDir . 'index.php', '<?php ');
        $this->createFile($addonDir . 'class1.php', '<?php class TempClass1{}');

        BearFramework\Addons::register('tempaddon', $addonDir);
        $app->addons->add('tempaddon', ['option1' => 5]);

        $context = $app->getContext($addonDir);

        $this->assertTrue(isset($context->options['option1']));
        $this->assertTrue($context->options['option1'] === 5);

        $context->classes->add('TempClass1', 'class1.php');
        $this->assertTrue(class_exists('TempClass1'));

        $context->assets->addDir('assets/');

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);
    }

    /**
     * 
     */
    public function testUnknownContext()
    {
        $app = $this->getApp();
        $addonDir = $app->config->addonsDir . 'tempaddong' . uniqid() . '/';
        $this->createFile($addonDir . 'index.php', '<?php ');
        // Addon is not added
        $this->setExpectedException('Exception');
        $app->getContext($addonDir);
    }

    /**
     * 
     */
    public function testAppContextInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\AppContext(1);
    }

    /**
     * 
     */
    public function testAddonContextInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\AddonContext(1);
    }

    /**
     * 
     */
    public function testGetContextInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->getContext(1);
    }

    /**
     * 
     */
    public function testContextInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Context(1);
    }

    /**
     * 
     */
    public function testContextAssetsInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Context\Assets(1);
    }

    /**
     * 
     */
    public function testContextAssetsInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextAssets = new \BearFramework\App\Context\Assets('dir');
        $contextAssets->getUrl(1);
    }

    /**
     * 
     */
    public function testContextAssetsInvalidArguments3()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextAssets = new \BearFramework\App\Context\Assets('dir');
        $contextAssets->getUrl('file.png', 1);
    }

    /**
     * 
     */
    public function testContextClassesInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new \BearFramework\App\Context\Classes(1);
    }

    /**
     * 
     */
    public function testContextClassesInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextClasses = new \BearFramework\App\Context\Classes('dir');
        $contextClasses->add(1, 'testclass.php');
    }

    /**
     * 
     */
    public function testContextClassesInvalidArguments3()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextClasses = new \BearFramework\App\Context\Classes('dir');
        $contextClasses->add('TestClass', 1);
    }

}
