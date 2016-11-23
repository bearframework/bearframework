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
 * Provides information about the current request
 * 
 * @property string $scheme The request scheme
 * @property string $host The request hostname
 * @property int|null $port The request port
 * @property \BearFramework\App\Request\Path $path The request path
 * @property \BearFramework\App\Request\Query $query The request query string
 * @property \BearFramework\App\Request\Headers $headers The request headers
 * @property \BearFramework\App\Request\Cookies $cookies The request cookies
 * @property \BearFramework\App\Request\Data $data The request POST data
 * @property \BearFramework\App\Request\Files $files The request files data
 */
class Request
{

    /**
     * The request method
     * 
     * @var string 
     */
    public $method = '';

    /**
     * The base URL of the request
     * 
     * @var string 
     */
    public $base = '';

    /**
     * Dependency Injection container
     * 
     * @var \BearFramework\App\Container 
     */
    public $container = null;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->container = new App\Container();

        $this->container->set('path', App\Request\Path::class);
        $this->container->set('query', App\Request\Query::class);
        $this->container->set('headers', App\Request\Headers::class);
        $this->container->set('cookies', App\Request\Cookies::class);
        $this->container->set('data', App\Request\Data::class);
        $this->container->set('files', App\Request\Files::class);
    }

    /**
     * Returns the full URL of the request
     * 
     * @return string The full URL of the request
     */
    public function __toString()
    {
        return $this->base . (string) $this->path;
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
        if ($name === 'scheme' || $name === 'host' || $name === 'port') {
            $data = parse_url($this->base);
            return isset($data[$name]) ? $data[$name] : null;
        }
        if ($this->container->exists($name)) {
            return $this->container->get($name);
        }
        throw new \Exception('The property requested (' . $name . ') cannot be found in the dependency injection container');
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if ($name === 'scheme' || $name === 'host' || $name === 'port') {
            if ($name === 'scheme' && !is_string($value)) {
                throw new \InvalidArgumentException('The value of the scheme property must be of type string');
            }
            if ($name === 'host' && !is_string($value)) {
                throw new \InvalidArgumentException('The value of the scheme property must be of type string');
            }
            if ($name === 'port' && !((is_string($value) && preg_match('/^[0-9]*$/', $value) === 1) || (is_int($value) && $value > 0) || $value === null)) {
                throw new \InvalidArgumentException('The value of the port property must be of type string (numeric), positve int or null');
            }
            $data = parse_url($this->base);
            $this->base = ($name === 'scheme' ? $value : (isset($data['scheme']) ? $data['scheme'] : '')) . '://' . ($name === 'host' ? $value : (isset($data['host']) ? $data['host'] : '')) . ($name === 'port' ? (strlen($value) > 0 ? ':' . $value : '') : (isset($data['port']) ? ':' . $data['port'] : '')) . (isset($data['path']) ? $data['path'] : '');
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
        return $name === 'scheme' || $name === 'host' || $name === 'port' || $this->container->exists($name);
    }

}
