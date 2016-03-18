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
        BearFramework\Addons::register('addon1', $app->config->addonsDir . 'addon1/');

        $this->createFile($app->config->addonsDir . 'addon1/index.php', '<?php ?>');
        $app->addons->add('addon1', ['var' => 5]);
        $context = $app->getContext($app->config->addonsDir . 'addon1/');

        $this->assertTrue(is_array($context->options));
        $this->assertTrue(isset($context->options['var']));
        $this->assertTrue($context->options['var'] === 5);

        $this->setExpectedException('Exception');
        $context = $app->getContext($app->config->addonsDir . 'addon2/');
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
        BearFramework\Addons::register('addon1', $app->config->addonsDir . 'addon1/');

        $this->createFile($app->config->addonsDir . 'addon1/index.php', '<?php ?>');
        $this->assertTrue($app->addons->add('addon1'));
        $this->assertFalse($app->addons->add('addon1'));
    }

    /**
     * 
     */
    public function testNotValidAddon()
    {
        $app = $this->getApp();
        BearFramework\Addons::register('addon1', $app->config->addonsDir . 'addon1/');

        $this->setExpectedException('Exception');
        $this->assertTrue($app->addons->add('addon1'));
    }

    /**
     * 
     */
    public function testRegister()
    {
        BearFramework\Addons::register('name1', 'dir1', ['require' => ['name2']]);
        $this->assertTrue(BearFramework\Addons::exists('name1'));
        $this->assertTrue(BearFramework\Addons::getDir('name1') === 'dir1');
        $this->assertTrue(BearFramework\Addons::exists('name2') === false);
        $options = BearFramework\Addons::getOptions('name1');
        $this->assertTrue($options['require'][0] === 'name2');
    }

    /**
     * 
     */
    public function testGetDirError()
    {
        $this->setExpectedException('Exception');
        BearFramework\Addons::getDir('name1');
    }

    /**
     * 
     */
    public function testGetOptionsError()
    {
        $this->setExpectedException('Exception');
        BearFramework\Addons::getOptions('name1');
    }

    /**
     * 
     */
    public function testRequire()
    {
        $app = $this->getApp();
        $this->createFile($app->config->addonsDir . 'name1/index.php', '<?php class Addon1{}?>');
        $this->createFile($app->config->addonsDir . 'name2/index.php', '<?php class Addon2{}?>');
        BearFramework\Addons::register('name1', $app->config->addonsDir . 'name1/');
        BearFramework\Addons::register('name2', $app->config->addonsDir . 'name2/', ['require' => ['name1']]);
        $app->addons->add('name2');
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
        BearFramework\Addons::register('name1', 2);
    }

    /**
     * 
     */
    public function testRegisterInvalidArguments3()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register('name1', 'dir1/', 1);
    }

    /**
     * 
     */
    public function testExistsInvalidArguments1()
    {
        BearFramework\Addons::register('name1', 'dir1');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::exists(1);
    }

    /**
     * 
     */
    public function testGetDirInvalidArguments1()
    {
        BearFramework\Addons::register('name1', 'dir1');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::getDir(1);
    }

    /**
     * 
     */
    public function testGetOptionsInvalidArguments1()
    {
        BearFramework\Addons::register('name1', 'dir1');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::getOptions(1);
    }

}
