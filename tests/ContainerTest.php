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
        $app->container->set('test1', TestClass::class);
        $this->assertTrue($app->test1 instanceof TestClass);
        $this->assertTrue($app->test1->property1 === 1);
        $app->test1->property1 = 2;
        $this->assertTrue($app->test1 instanceof TestClass);
        $this->assertTrue($app->test1->property1 === 1);

        $app->container->set('test2', TestClass::class, ['singleton']);
        $this->assertTrue($app->test2 instanceof TestClass);
        $this->assertTrue($app->test2->property1 === 1);
        $app->test2->property1 = 2;
        $this->assertTrue($app->test2 instanceof TestClass);
        $this->assertTrue($app->test2->property1 === 2);
    }

    /**
     * 
     */
    public function testAddCallable()
    {
        $app = $this->getApp();
        $app->container->set('test1', function() {
            return new TestClass();
        });
        $this->assertTrue($app->test1 instanceof TestClass);
        $this->assertTrue($app->test1->property1 === 1);
        $app->test1->property1 = 2;
        $this->assertTrue($app->test1 instanceof TestClass);
        $this->assertTrue($app->test1->property1 === 1);

        $app->container->set('test2', function() {
            return new TestClass();
        }, ['singleton']);
        $this->assertTrue($app->test2 instanceof TestClass);
        $this->assertTrue($app->test2->property1 === 1);
        $app->test2->property1 = 2;
        $this->assertTrue($app->test2 instanceof TestClass);
        $this->assertTrue($app->test2->property1 === 2);
    }

    /**
     * 
     */
    public function testAddObject()
    {
        $app = $this->getApp();
        $object = new TestClass();
        $app->container->set('test', $object);
        $this->assertTrue($app->test instanceof TestClass);
        $this->assertTrue($app->test->property1 === 1);
        $app->test->property1 = 2;
        $this->assertTrue($app->test instanceof TestClass);
        $this->assertTrue($app->test->property1 === 2);
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
    public function testAddInvalidArgument3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->container->set('test1', TestClass::class, 1);
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
    public function testHasInvalidArgument1()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        $app->container->has(1);
    }

    /**
     * 
     */
    public function testGetMissingService1()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        $app->missingService->property;
    }

    /**
     * 
     */
    public function testGetMissingService2()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        $app->container->get('missingService');
    }

    /**
     * 
     */
    public function testIsset()
    {
        $app = $this->getApp();
        $app->container->set('test1', TestClass::class);
        $this->assertTrue(isset($app->test1) == true);
        $this->assertTrue(isset($app->test2) == false);
    }

}
