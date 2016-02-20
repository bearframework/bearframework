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
class UrlsTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testGet()
    {
        $app = $this->getApp();
        $app->request->base = "https://example.com/www";
        $this->assertTrue($app->urls->get('/') === "https://example.com/www/");
        $this->assertTrue($app->urls->get('/products/') === "https://example.com/www/products/");
        $this->setExpectedException('InvalidArgumentException');
        $app->urls->get(1);
    }

}
