<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * @runTestsInSeparateProcesses
 */
class RoutesTest extends BearFrameworkTestCase
{

    /**
     * 
     */
    public function testHomePage()
    {
        $app = $this->getApp();

        $app->request->path->set('/');
        $app->request->method = 'GET';
        $app->routes->add('/', function() {
            return new \BearFramework\App\Response\HTML('Hi from the home page');
        });

        $app->run();
        $this->expectOutputString('Hi from the home page');
    }

    /**
     * 
     */
    public function testPage()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/');
        $app->request->method = 'GET';
        $app->routes->add('/products/', function() {
            return new \BearFramework\App\Response\HTML('Hi from the products page');
        });

        $app->run();
        $this->expectOutputString('Hi from the products page');
    }

    /**
     * 
     */
    public function testWildcard1()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/laptop/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*', function() {
            return new \BearFramework\App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * 
     */
    public function testWildcard2()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/laptop/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*', function() {
            return new \BearFramework\App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * 
     */
    public function testWildcard3()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/laptop/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*/options/', function() {
            return new \BearFramework\App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * 
     */
    public function testWildcard4()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/laptop/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/*ions/', function() {
            return new \BearFramework\App\Response\HTML('Hi from the product page');
        });

        $app->run();
        $this->expectOutputString('Hi from the product page');
    }

    /**
     * 
     */
    public function testQuestionMark1()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/product/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/', function() use ($app) {
            return new \BearFramework\App\Response\HTML($app->request->path->getSegment(1));
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * 
     */
    public function testQuestionMark1NoMatch()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?', function() {
            return new \BearFramework\App\Response\HTML('');
        });

        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * 
     */
    public function testQuestionMark2()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/product/review/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/review/', function() use ($app) {
            return new \BearFramework\App\Response\HTML($app->request->path->getSegment(1));
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * 
     */
    public function testQuestionMark3()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/product/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/?/', function() use ($app) {
            return new \BearFramework\App\Response\HTML($app->request->path->getSegment(1) . '-' . $app->request->path->getSegment(2));
        });

        $app->run();
        $this->expectOutputString('product-options');
    }

    /**
     * 
     */
    public function testQuestionMark4()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/product/options/color/blue/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/options/?/blue/', function() use ($app) {
            return new \BearFramework\App\Response\HTML($app->request->path->getSegment(1) . '-' . $app->request->path->getSegment(3));
        });

        $app->run();
        $this->expectOutputString('product-color');
    }

    /**
     * 
     */
    public function testQuestionMark5()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/product/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?options/', function() use ($app) {
            return new \BearFramework\App\Response\HTML('product');
        });

        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * 
     */
    public function testQuestionMark6()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/product/options/');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/options/', function() use ($app) {
            return new \BearFramework\App\Response\HTML($app->request->path->getSegment(1));
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * 
     */
    public function testQuestionMark7()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/product/options');
        $app->request->method = 'GET';
        $app->routes->add('/products/?/options', function() use ($app) {
            return new \BearFramework\App\Response\HTML($app->request->path->getSegment(1));
        });

        $app->run();
        $this->expectOutputString('product');
    }

    /**
     * 
     */
    public function testMultipleRoutes1()
    {
        $app = $this->getApp();

        $app->request->path->set('/services/');
        $app->request->method = 'GET';
        $app->routes->add(['/services/', '/our-services/'], function() {
            return new \BearFramework\App\Response\HTML('Hi from the services page');
        });

        $app->run();
        $this->expectOutputString('Hi from the services page');
    }

    /**
     * 
     */
    public function testMultipleRoutes2()
    {
        $app = $this->getApp();

        $app->request->path->set('/our-services/');
        $app->request->method = 'GET';
        $app->routes->add(['/services/', '/our-services/'], function() {
            return new \BearFramework\App\Response\HTML('Hi from the services page');
        });

        $app->run();
        $this->expectOutputString('Hi from the services page');
    }

    /**
     * 
     */
    public function testNotFound()
    {
        $app = $this->getApp();

        $app->request->path->set('/products/');
        $app->request->method = 'GET';
        $app->routes->add('/', function() {
            return new \BearFramework\App\Response\HTML('Hi from the home page');
        });

        $app->run();
        $this->expectOutputString('Not Found');
    }

    /**
     * 
     */
    public function testRouteResponse()
    {
        $app = $this->getApp();

        $app->routes->add('/', function() {
            return new \BearFramework\App\Response\HTML('home');
        });
        $request = new \BearFramework\App\Request();
        $request->path->set('/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response instanceof \BearFramework\App\Response\HTML);
        $this->assertTrue($response->content === 'home');
    }

    /**
     * 
     */
    public function testMissingRoute()
    {
        $app = $this->getApp();

        $app->routes->add('/', function() {
            return new \BearFramework\App\Response\HTML('home');
        });
        $request = new \BearFramework\App\Request();
        $request->path->set('/products/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * 
     */
    public function testRouteMethod()
    {
        $app = $this->getApp();

        $app->routes->add('/', function() {
            return new \BearFramework\App\Response\HTML('home');
        }, ['GET', 'HTTPS']);
        $request = new \BearFramework\App\Request();
        $request->method = 'GET';
        $request->base = 'https://example.com';
        $request->path->set('/');
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response instanceof \BearFramework\App\Response\HTML);
        $this->assertTrue($response->content === 'home');
    }

    /**
     * 
     */
    public function testNotMatchingRouteMethod()
    {
        $app = $this->getApp();

        $app->routes->add('/', function() {
            return new \BearFramework\App\Response\HTML('home');
        }, ['POST']);
        $request = new \BearFramework\App\Request();
        $request->method = 'GET';
        $request->scheme = 'https';
        $request->path->set('/');
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * 
     */
    public function testInvalidResponse()
    {
        $app = $this->getApp();

        $app->routes->add('/', function() {
            return 3;
        });
        $request = new \BearFramework\App\Request();
        $request->path->set('/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * 
     */
    public function testMissingRoutes()
    {
        $app = $this->getApp();

        $request = new \BearFramework\App\Request();
        $request->path->set('/');
        $request->method = 'GET';
        $response = $app->routes->getResponse($request);
        $this->assertTrue($response === null);
    }

    /**
     * 
     */
    public function testInvalidArguments2()
    {
        $app = $this->getApp();

        $this->setExpectedException('InvalidArgumentException');
        $app->routes->add([], function() {
            
        });
    }

}
