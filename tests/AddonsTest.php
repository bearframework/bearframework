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
class AddonsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testGetOptions()
    {
        $addonsDir = sys_get_temp_dir() . '/addons' . uniqid() . '/';
        App\Utilities\Dir::make($addonsDir);
        $app = new App([
            'addonsDir' => $addonsDir
        ]);
        $app->addons->add('addon1', ['var' => 5]);

        $options = $app->addons->getOptions('addon1');
        $this->assertTrue(is_array($options));
        $this->assertTrue(isset($options['var']));
        $this->assertTrue($options['var'] === 5);

        $options = $app->addons->getOptions('addon2');
        $this->assertTrue(is_array($options));
        $this->assertTrue(sizeof($options) === 0);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments1()
    {
        $app = new App(); // missing addons dir
        $this->setExpectedException('Exception');
        $app->addons->add('addon1');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments2()
    {
        $addonsDir = sys_get_temp_dir() . '/addons' . uniqid() . '/';
        App\Utilities\Dir::make($addonsDir);
        $app = new App([
            'addonsDir' => $addonsDir
        ]);
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->add(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments3()
    {
        $addonsDir = sys_get_temp_dir() . '/addons' . uniqid() . '/';
        App\Utilities\Dir::make($addonsDir);
        $app = new App([
            'addonsDir' => $addonsDir
        ]);
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->add('addon1', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments4()
    {
        $addonsDir = sys_get_temp_dir() . '/addons' . uniqid() . '/';
        App\Utilities\Dir::make($addonsDir);
        $app = new App([
            'addonsDir' => $addonsDir
        ]);
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->getOptions(1);
    }

}
