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
class ClassesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testAdd()
    {
        $app = $this->getApp();
        $this->makeFile($app->config->appDir . '/tempClass1.php', '<?php class TempClass1{}');
        $this->assertFalse($app->classes->exists('TempClass1'));
        $app->classes->add('TempClass1', $app->config->appDir . '/tempClass1.php');
        $this->assertTrue($app->classes->exists('TempClass1'));
        $this->assertTrue(class_exists('TempClass1'));
    }

    public function testNamespaceWildcard()
    {
        $app = $this->getApp();
        $tempDir = $this->getTempDir();
        $this->makeFile($tempDir . '/classes/Namespace1/Class1.php', '<?php 
namespace Namespace1;

class Class1{
}');
        $this->makeFile($tempDir . '/classes/Namespace1/Class2.php', '<?php 
namespace Namespace1;

class Class2{
}');
        $this->makeFile($tempDir . '/classes/Namespace1/Namespace2/Class3.php', '<?php 
namespace Namespace1\Namespace2;

class Class3{
}');
        $app->classes->add('Namespace1\*', $tempDir . '/classes/Namespace1/*.php');
        $app->classes->add('Namespace1\Namespace2\*', $tempDir . '/classes/Namespace1/Namespace2/*.php');
        $this->assertEquals(get_class(new Namespace1\Class1()), 'Namespace1\Class1');
        $this->assertEquals(get_class(new Namespace1\Class2()), 'Namespace1\Class2');
        $this->assertEquals(get_class(new Namespace1\Namespace2\Class3()), 'Namespace1\Namespace2\Class3');
    }

}
