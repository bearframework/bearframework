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
class AddonsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testOptions()
    {
        $app = $this->getApp();

        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');

        $app->addons->add('addon1', ['var' => 5]);
        $context = $app->getContext($app->config->addonsDir . '/addon1/');

        $this->assertTrue(is_array($context->options));
        $this->assertTrue(isset($context->options['var']));
        $this->assertTrue($context->options['var'] === 5);

        $this->setExpectedException('Exception');
        $context = $app->getContext($app->config->addonsDir . '/addon2/');
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->add(1);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->add('addon1', 1);
    }

    /**
     * 
     */
    public function testMultipleAds()
    {
        $app = $this->getApp();

        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');

        $this->assertTrue($app->addons->add('addon1'));
        $this->assertFalse($app->addons->add('addon1'));
    }

    /**
     * 
     */
    public function testNotValidAddon() // missing index file
    {
        $app = $this->getApp();

        $this->createDir($app->config->addonsDir . '/addon1/');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');

        $this->setExpectedException('Exception');
        $this->assertTrue($app->addons->add('addon1'));
    }

    /**
     * 
     */
    public function testRegister()
    {
        $app = $this->getApp();

        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/', ['require' => ['addon2']]);

        $this->assertTrue(BearFramework\Addons::exists('addon1'));
        $this->assertTrue(BearFramework\Addons::getDir('addon1') === realpath($app->config->addonsDir . '/addon1/'));
        $this->assertTrue(BearFramework\Addons::exists('addon2') === false);
        $options = BearFramework\Addons::getOptions('addon1');
        $this->assertTrue($options['require'][0] === 'addon2');
    }

    /**
     * 
     */
    public function testGetList()
    {
        $app = $this->getApp();

        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        $this->createFile($app->config->addonsDir . '/addon2/index.php', '<?php ?>');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/');
        $list = BearFramework\Addons::getList();
        $this->assertTrue($list === ['addon1', 'addon2']);
    }

    /**
     * 
     */
    public function testGetDirError()
    {
        $this->setExpectedException('Exception');
        BearFramework\Addons::getDir('addon1');
    }

    /**
     * 
     */
    public function testGetOptionsError()
    {
        $this->setExpectedException('Exception');
        BearFramework\Addons::getOptions('addon1');
    }

    /**
     * 
     */
    public function testRequire()
    {
        $app = $this->getApp();
        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php class Addon1{}?>');
        $this->createFile($app->config->addonsDir . '/addon2/index.php', '<?php class Addon2{}?>');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/', ['require' => ['addon1']]);
        $app->addons->add('addon2');
        $this->assertTrue(class_exists('Addon1'));
        $this->assertTrue(class_exists('Addon2'));
    }

    /**
     * 
     */
    public function testRegisterInvalidArguments1()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register(1, 'dir1');
    }

    /**
     * 
     */
    public function testRegisterInvalidArguments2()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register('addon1', 2);
    }

    /**
     * 
     */
    public function testRegisterInvalidArguments3()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register('addon1', 'missing/dir');
    }

    /**
     * 
     */
    public function testRegisterInvalidArguments4()
    {
        $app = $this->getApp();
        $this->createDir($app->config->addonsDir . '/addon1');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1', 1);
    }

    /**
     * 
     */
    public function testExistsInvalidArguments1()
    {
        $app = $this->getApp();
        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::exists(1);
    }

    /**
     * 
     */
    public function testGetDirInvalidArguments1()
    {
        $app = $this->getApp();
        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::getDir(1);
    }

    /**
     * 
     */
    public function testGetOptionsInvalidArguments1()
    {
        $app = $this->getApp();
        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::getOptions(1);
    }

}
