<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
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
    public function testAddInvalidArgument1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->container->set(1, TestClass::class);
    }

    /**
     * 
     */
    public function testAddInvalidArgument2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->container->set('test1', 1);
    }

    /**
     * 
     */
    public function testGetInvalidArgument1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->container->get(1);
    }

    /**
     * 
     */
    public function testExistsInvalidArgument1()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        $app->container->exists(1);
    }

    /**
     * 
     */
    public function testGetMissingService1()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        $app->container->get('missingService');
    }

}
