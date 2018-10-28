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
class AddonsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testRegisterAndAdd()
    {
        $app = $this->getApp();

        $this->makeFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        $this->makeFile($app->config->addonsDir . '/addon2/index.php', '<?php ?>');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/', ['require' => ['addon1']]);
        $this->assertTrue(BearFramework\Addons::getList()->length === 2);

        $this->assertTrue(BearFramework\Addons::exists('addon1'));
        $this->assertTrue(BearFramework\Addons::get('addon1')->dir === $app->config->addonsDir . '/addon1');
        $this->assertTrue(BearFramework\Addons::exists('addon3') === false);
        $this->assertTrue(BearFramework\Addons::get('addon2')->options['require'][0] === 'addon1');

        $this->assertFalse($app->addons->exists('addon1'));
        $this->assertFalse($app->addons->exists('addon2'));

        $app->addons->add('addon2', ['var' => 5]);

        $this->assertTrue($app->addons->exists('addon1'));
        $this->assertTrue($app->addons->exists('addon2'));

        $addon1 = $app->addons->get('addon1');
        $this->assertTrue($addon1->id === 'addon1');
        $this->assertTrue($addon1->options === []);

        $addon2 = $app->addons->get('addon2');
        $this->assertTrue($addon2->id === 'addon2');
        $this->assertTrue($addon2->options['var'] === 5);

        $this->expectException('Exception');
        $context = $app->context->get($app->config->addonsDir . '/addon3/');
    }

    /**
     * 
     */
    public function testMultipleAds()
    {
        $app = $this->getApp();

        $this->makeFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');

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

        $this->makeDir($app->config->addonsDir . '/addon1/');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');

        $this->expectException('Exception');
        $this->assertTrue($app->addons->add('addon1'));
    }

    /**
     * 
     */
    public function testGetList()
    {
        $app = $this->getApp();

        $this->makeFile($app->config->addonsDir . '/addon1/index.php', '<?php ?>');
        $this->makeFile($app->config->addonsDir . '/addon2/index.php', '<?php ?>');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/');

        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/');

        $list = BearFramework\Addons::getList();
        $this->assertTrue($list[0]->id === 'addon1');
        $this->assertTrue($list[0]->dir === $app->config->addonsDir . '/addon1');
        $this->assertTrue($list[0]->options === []);
        $this->assertTrue($list[1]->id === 'addon2');
        $this->assertTrue($list[1]->dir === $app->config->addonsDir . '/addon2');
        $this->assertTrue($list[1]->options === []);
    }

    /**
     * 
     */
    public function testRequire()
    {
        $app = $this->getApp();
        $this->makeFile($app->config->addonsDir . '/addon1/index.php', '<?php class Addon1{}?>');
        $this->makeFile($app->config->addonsDir . '/addon2/index.php', '<?php class Addon2{}?>');
        BearFramework\Addons::register('addon1', $app->config->addonsDir . '/addon1/');
        BearFramework\Addons::register('addon2', $app->config->addonsDir . '/addon2/', ['require' => ['addon1']]);
        $app->addons->add('addon2');
        $this->assertTrue(class_exists('Addon1'));
        $this->assertTrue(class_exists('Addon2'));
    }

    /**
     * 
     */
    public function testInvalidArguments9()
    {
        $this->expectException('InvalidArgumentException');
        BearFramework\Addons::register('addon1', 'missing/dir');
    }

}
