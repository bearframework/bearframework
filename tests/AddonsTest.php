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
    public function testRegisterAndAdd()
    {
        $app = $this->getApp();

        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        $this->createFile($app->config->addonsDir . '/addon2/index.php', '<?php ?>');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/', ['require' => ['addon1']]);

        $this->assertTrue(BearFramework\Addons::exists('addon1'));
        $this->assertTrue(BearFramework\Addons::get('addon1')['dir'] === realpath($app->config->addonsDir . '/addon1/'));
        $this->assertTrue(BearFramework\Addons::exists('addon3') === false);
        $this->assertTrue(BearFramework\Addons::get('addon2')['options']['require'][0] === 'addon1');

        $this->assertFalse($app->addons->exists('addon1'));
        $this->assertFalse($app->addons->exists('addon2'));

        $app->addons->add('addon2', ['var' => 5]);

        $this->assertTrue($app->addons->exists('addon1'));
        $this->assertTrue($app->addons->exists('addon2'));

        $addon1Data = $app->addons->get('addon1');
        $this->assertTrue($addon1Data['id'] === 'addon1');
        $this->assertTrue($addon1Data['options'] === []);

        $addon2Data = $app->addons->get('addon2');
        $this->assertTrue($addon2Data['id'] === 'addon2');
        $this->assertTrue($addon2Data['options']['var'] === 5);

        $this->setExpectedException('Exception');
        $context = $app->context->get($app->config->addonsDir . '/addon3/');
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

        $this->setExpectedException('InvalidArgumentException');
        $this->assertTrue($app->addons->add('addon1'));
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
        $this->assertTrue($list[0]['id'] === 'addon1');
        $this->assertTrue($list[0]['dir'] === realpath($app->config->addonsDir . '/addon1/'));
        $this->assertTrue($list[0]['options'] === []);
        $this->assertTrue($list[1]['id'] === 'addon2');
        $this->assertTrue($list[1]['dir'] === realpath($app->config->addonsDir . '/addon2/'));
        $this->assertTrue($list[1]['options'] === []);
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
    public function testInvalidArguments3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->get('addon1');
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->exists(1);
    }

    /**
     * 
     */
    public function testInvalidArguments6()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::get('addon1');
    }

    /**
     * 
     */
    public function testInvalidArguments7()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register(1, 'dir1');
    }

    /**
     * 
     */
    public function testInvalidArguments8()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register('addon1', 2);
    }

    /**
     * 
     */
    public function testInvalidArguments9()
    {
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register('addon1', 'missing/dir');
    }

    /**
     * 
     */
    public function testInvalidArguments10()
    {
        $app = $this->getApp();
        $this->createDir($app->config->addonsDir . '/addon1');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments11()
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
    public function testInvalidArguments12()
    {
        $app = $this->getApp();
        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::get(1);
    }

    /**
     * 
     */
    public function testInvalidArguments13()
    {
        $app = $this->getApp();
        $this->createFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        $this->setExpectedException('InvalidArgumentException');
        BearFramework\Addons::get(1);
    }

}
