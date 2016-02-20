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

        $app->addons->add('addon1', ['var' => 5]);
        $this->createFile($app->config->addonsDir . 'addon1/index.php', '<?== ?>');
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

}
