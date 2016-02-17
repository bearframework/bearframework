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
    public function testGetOptions()
    {
        $app = $this->getApp();
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
     * 
     */
    public function testInvalidArguments1()
    {
        $app = $this->getApp([
            'addonsDir' => null
        ]);
        $this->setExpectedException('\BearFramework\App\InvalidConfigOptionException');
        $app->addons->add('addon1');
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->add(1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->add('addon1', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->addons->getOptions(1);
    }

}
