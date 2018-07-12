<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

class TestClass
{

    public $property1 = 1;

}

/**
 * @runTestsInSeparateProcesses
 */
class ContainerTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAddString()
    {
        $app = $this->getApp();
        $app->container->set('test2', TestClass::class);
        $this->assertTrue($app->container->get('test2') instanceof TestClass);
        $this->assertTrue($app->container->get('test2')->property1 === 1);
        $app->container->get('test2')->property1 = 2;
        $this->assertTrue($app->container->get('test2') instanceof TestClass);
        $this->assertTrue($app->container->get('test2')->property1 === 2);
    }

    /**
     * 
     */
    public function testAddCallable()
    {
        $app = $this->getApp();
        $app->container->set('test2', function() {
            return new TestClass();
        });
        $this->assertTrue($app->container->get('test2') instanceof TestClass);
        $this->assertTrue($app->container->get('test2')->property1 === 1);
        $app->container->get('test2')->property1 = 2;
        $this->assertTrue($app->container->get('test2') instanceof TestClass);
        $this->assertTrue($app->container->get('test2')->property1 === 2);
    }

    /**
     * 
     */
    public function testAddObject()
    {
        $app = $this->getApp();
        $object = new TestClass();
        $app->container->set('test', $object);
        $this->assertTrue($app->container->get('test') instanceof TestClass);
        $this->assertTrue($app->container->get('test')->property1 === 1);
        $app->container->get('test')->property1 = 2;
        $this->assertTrue($app->container->get('test') instanceof TestClass);
        $this->assertTrue($app->container->get('test')->property1 === 2);
    }

    /**
     * 
     */
    public function testGetMissingService1()
    {
        $app = $this->getApp();
        $this->expectException('Exception');
        $app->container->get('missingService');
    }

}
