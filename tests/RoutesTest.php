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
class RoutesTest extends PHPUnit_Framework_TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testHomePage()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/');
        $app->request->method = 'GET';
        $app->routes->add('/', function() {
            return new \App\Response\HTML('Hi from the home page');
        });

        $app->run();
        $this->expectOutputString('Hi from the home page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testPage()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/');
        $app->request->method = 'GET';
        $app->routes->add('/products/', function() {
            return new \App\Response\HTML('Hi from the products page');
        });

        $app->run();
        $this->expectOutputString('Hi from the products page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testWildcard1()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/laptop/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*', function() {
            return new \App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testWildcard2()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/laptop/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*', function() {
            return new \App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testWildcard3()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/laptop/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*/options/', function() {
            return new \App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testWildcard4()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/laptop/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*ions/', function() {
            return new \App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark1()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/product/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/', function() use ($app) {
            return new \App\Response\HTML($app->request->path[1]);
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark1NoMatch()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?', function() {
            return new \App\Response\HTML('');
        });

        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark2()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/product/review/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/review/', function() use ($app) {
            return new \App\Response\HTML($app->request->path[1]);
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark3()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/product/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/?/', function() use ($app) {
            return new \App\Response\HTML($app->request->path[1] . '-' . $app->request->path[2]);
        });

        $app->run();
        $this->expectOutputString('product-options');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark4()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/product/options/color/blue/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/options/?/blue/', function() use ($app) {
            return new \App\Response\HTML($app->request->path[1] . '-' . $app->request->path[3]);
        });

        $app->run();
        $this->expectOutputString('product-color');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark5()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/product/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?options/', function() use ($app) {
            return new \App\Response\HTML('product');
        });

        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark6()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/product/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/options/', function() use ($app) {
            return new \App\Response\HTML($app->request->path[1]);
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * @runInSeparateProcess
     */
    public function testQuestionMark7()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/product/options');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/options', function() use ($app) {
            return new \App\Response\HTML($app->request->path[1]);
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * @runInSeparateProcess
     */
    public function testMultipleRoutes1()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/services/');
        $app->request->method = 'GET';
        $app->routes->add(['/services/', '/our-services/'], function() {
            return new \App\Response\HTML('Hi from the services page');
        });

        $app->run();
        $this->expectOutputString('Hi from the services page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testMultipleRoutes2()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/our-services/');
        $app->request->method = 'GET';
        $app->routes->add(['/services/', '/our-services/'], function() {
            return new \App\Response\HTML('Hi from the services page');
        });

        $app->run();
        $this->expectOutputString('Hi from the services page');
    }

    /**
     * @runInSeparateProcess
     */
    public function testNotFound()
    {
        $app = new App();

        $app->request->path = new \App\Request\Path('/products/');
        $app->request->method = 'GET';
        $app->routes->add('/', function() {
            return new \App\Response\HTML('Hi from the home page');
        });

        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * @runInSeparateProcess
     */
    public function testRouteResponse()
    {
        $app = new App();

        $app->routes->add('/', function() {
            return new \App\Response\HTML('home');
        });
        $request = new \App\Request();
        $request->path = new \App\Request\Path('/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response instanceof \App\Response\HTML);
        $this->assertTrue($response->content === 'home');
    }

    /**
     * @runInSeparateProcess
     */
    public function testMissingRoute()
    {
        $app = new App();

        $app->routes->add('/', function() {
            return new \App\Response\HTML('home');
        });
        $request = new \App\Request();
        $request->path = new \App\Request\Path('/products/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testRouteMethod()
    {
        $app = new App();

        $app->routes->add('/', function() {
            return new \App\Response\HTML('home');
        }, ['GET', 'HTTPS']);
        $request = new \App\Request();
        $request->method = 'GET';
        $request->base = 'https://example.com';
        $request->path = new \App\Request\Path('/');
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response instanceof \App\Response\HTML);
        $this->assertTrue($response->content === 'home');
    }

    /**
     * @runInSeparateProcess
     */
    public function testNotMatchingRouteMethod()
    {
        $app = new App();

        $app->routes->add('/', function() {
            return new \App\Response\HTML('home');
        }, ['POST']);
        $request = new \App\Request();
        $request->method = 'GET';
        $request->scheme = 'https';
        $request->path = new \App\Request\Path('/');
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidResponse()
    {
        $app = new App();

        $app->routes->add('/', function() {
            return 3;
        });
        $request = new \App\Request();
        $request->path = new \App\Request\Path('/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testMissingRoutes()
    {
        $app = new App();

        $request = new \App\Request();
        $request->path = new \App\Request\Path('/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments1()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->routes->add(1, function() {
            
        });
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments2()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->routes->add([], function() {
            
        });
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments3()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->routes->add([1], function() {
            
        });
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments4()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->routes->add('/', null);
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments5()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->routes->add('/', function() {
            
        }, 'OPTION');
    }

    /**
     * @runInSeparateProcess
     */
    public function testInvalidArguments6()
    {
        $app = new App();

        $this->setExpectedException('InvalidArgumentException');
        $app->routes->getResponse(null);
    }

}
