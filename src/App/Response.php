<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Response object
 * 
 * @property \BearFramework\App\Response\Headers $headers The response headers
 * @property \BearFramework\App\Response\Cookies $cookies The response cookies
 */
class Response
{

    /**
     * The content of the response
     * 
     * @var string 
     */
    public $content = '';

    /**
     * The response status code
     * 
     * @var int 
     */
    public $statusCode = 200;

    /**
     * The response character set
     * 
     * @var string 
     */
    public $charset = '';

    /**
     * Dependency Injection container
     * 
     * @var \BearFramework\App\Container 
     */
    public $container = null;

    /**
     * The constructor
     * 
     * @param string $content The content of the response
     * @throws \InvalidArgumentException
     */
    public function __construct($content = '')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }

        $this->content = $content;

        $this->container = new App\Container();

        $this->container->set('headers', App\Response\Headers::class);
        $this->container->set('cookies', App\Response\Cookies::class);
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($this->container->exists($name)) {
            return $this->container->get($name);
        }
        throw new \Exception('The property requested (' . $name . ') cannot be found in the dependency injection container');
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return $this->container->exists($name);
    }

}
