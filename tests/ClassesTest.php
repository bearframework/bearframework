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
        $this->makeFile($app->config['appDir'] . '/tempClass1.php', '<?php class TempClass1{}');
        $this->assertFalse($app->classes->exists('TempClass1'));
        $app->classes->add('TempClass1', $app->config['appDir'] . '/tempClass1.php');
        $this->assertTrue($app->classes->exists('TempClass1'));
        $this->assertTrue(class_exists('TempClass1'));
        $this->assertFalse($app->classes->exists('TempClass2'));
        $this->assertFalse(class_exists('TempClass2'));
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
        $this->makeFile($tempDir . '/classes/Context1/Namespace1/Class4.php', '<?php 
namespace Namespace1;

class Class4{
}');
        $this->makeFile($tempDir . '/classes/Context2/Namespace1/Class5.php', '<?php 
namespace Namespace1;

class Class5{
}');

        $app->classes->add('Namespace1\*', $tempDir . '/classes/Namespace1/*.php');
        $app->classes->add('Namespace1\Namespace2\*', $tempDir . '/classes/Namespace1/Namespace2/*.php');
        $app->classes->add('Namespace1\*', $tempDir . '/classes/Context1/Namespace1/*.php');
        $app->classes->add('Namespace1\*', $tempDir . '/classes/Context2/Namespace1/*.php');

        $classesToTest = [
            'Namespace1\Class1' => true,
            'Namespace1\Class2' => true,
            'Namespace1\Namespace2\Class3' => true,
            'Namespace1\Class4' => true,
            'Namespace1\Class5' => true,
            'Namespace1\Class6' => false,
        ];

        foreach ($classesToTest as $class => $expectedToExist) {
            if ($expectedToExist) {
                $this->assertTrue(class_exists($class));
                $this->assertTrue($app->classes->exists($class));
            } else {
                $this->assertFalse(class_exists($class));
                $this->assertFalse($app->classes->exists($class));
            }
        }
    }

}
