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
 * @property string $content The content of the response
 * @property string $statusCode The response status code
 * @property string $charset The response character set
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
    private $content = '';

    /**
     * The response status code
     * 
     * @var int|null 
     */
    private $statusCode = 200;

    /**
     * The response character set
     * 
     * @var string 
     */
    private $charset = '';

    /**
     * Services container
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
        if ($name === 'content') {
            return $this->content;
        }
        if ($name === 'statusCode') {
            return $this->statusCode;
        }
        if ($name === 'charset') {
            return $this->charset;
        }
        if ($this->container->exists($name)) {
            return $this->container->get($name);
        }
        throw new \Exception('The property requested (' . $name . ') cannot be found in the services container');
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        if ($name === 'content') {
            if (!is_string($value)) {
                throw new \Exception('The content property value must be of type string');
            }
            $this->content = $value;
        } elseif ($name === 'statusCode') {
            if (!is_int($value) && $value !== null) {
                throw new \Exception('The statusCode property value must be of type int');
            }
            $this->statusCode = $value;
        } elseif ($name === 'charset') {
            if (!is_string($value)) {
                throw new \Exception('The charset property value must be of type string');
            }
            $this->charset = $value;
        }
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        if ($name === 'content' || $name === 'statusCode' || $name === 'charset') {
            return true;
        }
        return $this->container->exists($name);
    }

    /**
     * Magic method
     * 
     * @param string $name
     */
    public function __unset($name)
    {
        if ($name === 'content') {
            $this->content = '';
        } elseif ($name === 'statusCode') {
            $this->statusCode = null;
        } elseif ($name === 'charset') {
            $this->charset = '';
        }
    }

}
