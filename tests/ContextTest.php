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
        \BearFramework\App\Utilities\Dir::make($app->config->appDir);

        $this->createFile($app->config->appDir . 'index.php', '<?php ');
        $this->createFile($app->config->appDir . 'class1.php', '<?php class TempClass1{}');
        $this->createFile($app->config->appDir . 'class2.php', '<?php class TempClass2{}');

        $context = new \BearFramework\App\AppContext($app->config->appDir);

        $this->assertTrue($context->load('class1.php'));
        $this->assertTrue(class_exists('TempClass1'));

        $context->classes->add('TempClass2', 'class2.php');
        $this->assertTrue(class_exists('TempClass2'));

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);
    }

    /**
     * 
     */
    public function testAddonContext()
    {
        $app = $this->getApp();
        $addonID = 'tempaddong' . uniqid();
        $addonDir = $app->config->addonsDir . $addonID . '/';
        \BearFramework\App\Utilities\Dir::make($addonDir);
        $app->request->base = 'http://example.com/www';

        $this->createFile($addonDir . 'index.php', '<?php ');
        $this->createFile($addonDir . 'class1.php', '<?php class TempClass1{}');
        $this->createFile($addonDir . 'class2.php', '<?php class TempClass2{}');
        $app->addons->add($addonID, ['option1' => 5]);

        $context = new \BearFramework\App\AddonContext($addonDir);

        $options = $context->getOptions();
        $this->assertTrue(isset($options['option1']));
        $this->assertTrue($options['option1'] === 5);

        $this->assertTrue($context->load('class1.php'));
        $this->assertTrue(class_exists('TempClass1'));

        $context->classes->add('TempClass2', 'class2.php');
        $this->assertTrue(class_exists('TempClass2'));

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);
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
    public function testAddonContextInvalidArguments2()
    {
        $app = $this->getApp([
            'addonsDir' => null
        ]);
        $this->setExpectedException('\BearFramework\App\InvalidConfigOptionException');
        $context = new \BearFramework\App\AddonContext('dir');
        $context->getOptions();
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
    public function testContextInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        $context = new \BearFramework\App\Context('dir');
        $context->load(1);
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
