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
class ContextTest extends BearFrameworkTestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testAppContext()
    {

        $app = $this->getApp();
        $app->request->base = 'http://example.com/www';
        App\Utilities\Dir::make($app->config->appDir);

        $this->createFile($app->config->appDir . 'index.php', '<?php ');
        $this->createFile($app->config->appDir . 'class1.php', '<?php class TempClass1{}');
        $this->createFile($app->config->appDir . 'class2.php', '<?php class TempClass2{}');

        $context = new App\AppContext($app->config->appDir);

        $this->assertTrue($context->load('class1.php'));
        $this->assertTrue(class_exists('TempClass1'));

        $context->classes->add('TempClass2', 'class2.php');
        $this->assertTrue(class_exists('TempClass2'));

        $this->assertTrue(strpos($context->assets->getUrl('assets/logo.png'), $app->request->base) === 0);
    }

    /**
     * @runInSeparateProcess
     */
    public function testAddonContext()
    {
        $app = $this->getApp();
        $addonID = 'tempaddong' . uniqid();
        $addonDir = $app->config->addonsDir . $addonID . '/';
        App\Utilities\Dir::make($addonDir);
        $app->request->base = 'http://example.com/www';

        $this->createFile($addonDir . 'index.php', '<?php ');
        $this->createFile($addonDir . 'class1.php', '<?php class TempClass1{}');
        $this->createFile($addonDir . 'class2.php', '<?php class TempClass2{}');
        $app->addons->add($addonID, ['option1' => 5]);

        $context = new App\AddonContext($addonDir);

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
     * @runInSeparateProcess
     */
    public function testAppContextInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new App\AppContext(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testAddonContextInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new App\AddonContext(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testAddonContextInvalidArguments2()
    {
        $app = $this->getApp([
            'addonsDir' => null
        ]);
        $this->setExpectedException('Exception');
        $context = new App\AddonContext('dir');
        $context->getOptions();
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new App\Context(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        $context = new App\Context('dir');
        $context->load(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextAssetsInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new App\Context\Assets(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextAssetsInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextAssets = new App\Context\Assets('dir');
        $contextAssets->getUrl(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextAssetsInvalidArguments3()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextAssets = new App\Context\Assets('dir');
        $contextAssets->getUrl('file.png', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextClassesInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        new App\Context\Classes(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextClassesInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextClasses = new App\Context\Classes('dir');
        $contextClasses->add(1, 'testclass.php');
    }

    /**
     * @runInSeparateProcess
     */
    public function testContextClassesInvalidArguments3()
    {
        $this->setExpectedException('InvalidArgumentException');
        $contextClasses = new App\Context\Classes('dir');
        $contextClasses->add('TestClass', 1);
    }

}
