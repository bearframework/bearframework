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
class ComponentsTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testProccess()
    {
        $app = new App();

        $content = '<!DOCTYPE html><html><head></head><body>content</body></html>';
        $result = $app->components->process('<component src="data:base64,' . base64_encode($content) . '"></component>');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === $content);

        $content = '<!DOCTYPE html><html><head></head><body>content</body></html>';
        $app->components->addAlias('newContent', 'data:base64,' . base64_encode($content));
        $result = $app->components->process('<component src="newContent" />');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === $content);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInsertHTML()
    {
        $app = new App();

        $result = $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 'afterBodyBegin');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === '<!DOCTYPE html><html><head></head><body>newcontent</body></html>');

        $result = $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 'beforeBodyEnd');
        $this->assertTrue(str_replace(["\n\r", "\r\n", "\n"], "", $result) === '<!DOCTYPE html><html><head></head><body>contentnew</body></html>');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments1()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->addAlias(1, 'longName');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments2()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->addAlias('shortName', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments3()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->process(1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments4()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML(1, 'new', 'beforeBodyEnd');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments5()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 1, 'beforeBodyEnd');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments6a()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 1);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments6b()
    {
        $app = new App();
        $this->setExpectedException('InvalidArgumentException');
        $app->components->insertHTML('<!DOCTYPE html><html><head></head><body>content</body></html>', 'new', 'somethingWrong');
    }

}
