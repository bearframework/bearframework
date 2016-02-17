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
class ComponentsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testProccess()
    {
        $app = $this->getApp();

        $content = '<!DOCTYPE html><html><head></head><body>content</body></html>';
        $result = $app->components->process('<component src="data:base64,' . base64_encode($content) . '"></component>');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === $content);

        $content = '<!DOCTYPE html><html><head></head><body>content</body></html>';
        $app->components->addAlias('newContent', 'data:base64,' . base64_encode($content));
        $result = $app->components->process('<component src="newContent" />');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === $content);
    }

    /**
     * 
     */
    public function testInsertHTML()
    {
        $app = $this->getApp();

        $result = $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 'afterBodyBegin');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === '<!DOCTYPE html><html><head></head><body>newcontent</body></html>');

        $result = $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 'beforeBodyEnd');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === '<!DOCTYPE html><html><head></head><body>contentnew</body></html>');
    }

    /**
     * 
     */
    public function testFile()
    {
        $app = $this->getApp();
        \BearFramework\App\Utilities\Dir::make($app->config->appDir);
        \BearFramework\App\Utilities\Dir::make($app->config->addonsDir . 'addon1/');

        $this->createFile($app->config->appDir . 'component1.php', '<!DOCTYPE html><html><head></head><body>content1<component src="file:' . $app->config->addonsDir . 'addon1/component2.php" /></body></html>');
        $this->createFile($app->config->addonsDir . 'addon1/component2.php', '<!DOCTYPE html><html><head></head><body>content2</body></html>');

        $result = $app->components->process('<component src="file:' . $app->config->appDir . 'component1.php" />');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === '<!DOCTYPE html><html><head></head><body>content1content2</body></html>');
    }

    /**
     * 
     */
    public function testInvalidArguments1()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->addAlias(1, 'longName');
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->addAlias('shortName', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments3()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->process(1);
    }

    /**
     * 
     */
    public function testInvalidArguments4()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML(1, 'new', 'beforeBodyEnd');
    }

    /**
     * 
     */
    public function testInvalidArguments5()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 1, 'beforeBodyEnd');
    }

    /**
     * 
     */
    public function testInvalidArguments6a()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 1);
    }

    /**
     * 
     */
    public function testInvalidArguments6b()
    {
        $app = $this->getApp();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 'somethingWrong');
    }

    /**
     * 
     */
    public function testInvalidArguments7a()
    {
        $app = $this->getApp();
        $this->setExpectedException('Exception');
        $app->components->process('<component src="file:missing/dir/component1.php" />');
    }

    /**
     * 
     */
    public function testInvalidArguments7b()
    {
        $wrongDir = $this->getTestDir() . 'wrongdir' . uniqid() . '/';
        \BearFramework\App\Utilities\Dir::make($wrongDir);

        $this->createFile($wrongDir . 'component1.php', '<!DOCTYPE html><html><head></head><body>content</body></html>');

        $app = $this->getApp();
        $this->setExpectedException('Exception');
        $app->components->process('<component src="file:' . $wrongDir . 'component1.php" />');
    }

}
