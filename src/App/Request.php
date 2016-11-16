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
 * @property array $headers The request headers
 * @property array $cookies The request cookies
 * @property array $data The request POST data
 * @property array $files The request files data
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
     * The path of the request. The path parts can be accessed by their indexes.
     * 
     * @var \BearFramework\App\Request\Path 
     */
    public $path = null;

    /**
     * The query string of the request. The query parts can be accessed by their names.
     * 
     * @var \BearFramework\App\Request\Query 
     */
    public $query = null;

    /**
     * The request headers
     * 
     * @var array|null 
     */
    private $headers = null;

    /**
     * The request cookies
     * 
     * @var array|null 
     */
    private $cookies = null;

    /**
     * The request POST data
     * 
     * @var array|null 
     */
    private $data = null;

    /**
     * The request files data
     * 
     * @var array|null 
     */
    private $files = null;

    /**
     * The constructor
     */
    public function __construct()
    {
        $this->path = new App\Request\Path();
        $this->query = new App\Request\Query();
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
        } elseif ($name === 'headers') {
            if ($this->headers === null) {
                $this->headers = new \ArrayObject();
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $this->headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                    }
                }
            }
            return $this->headers;
        } elseif ($name === 'cookies') {
            if ($this->cookies === null) {
                $this->cookies = new \ArrayObject($_COOKIE);
            }
            return $this->cookies;
        } elseif ($name === 'data') {
            if ($this->data === null) {
                $this->data = new \ArrayObject($_POST);
            }
            return $this->data;
        } elseif ($name === 'files') {
            if ($this->files === null) {
                $this->files = new \ArrayObject($_FILES);
            }
            return $this->files;
        }
        throw new \Exception('Undefined property: ' . $name);
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
        } elseif ($name === 'headers') {
            if (!is_array($value)) {
                throw new \InvalidArgumentException('The value of the headers property must be of type array');
            }
            $this->headers = $value;
        } elseif ($name === 'cookies') {
            if (!is_array($value)) {
                throw new \InvalidArgumentException('The value of the cookies property must be of type array');
            }
            $this->cookies = $value;
        } elseif ($name === 'data') {
            if (!is_array($value)) {
                throw new \InvalidArgumentException('The value of the data property must be of type array');
            }
            $this->data = $value;
        } elseif ($name === 'files') {
            if (!is_array($value)) {
                throw new \InvalidArgumentException('The value of the files property must be of type array');
            }
            $this->files = $value;
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
        return $name === 'scheme' || $name === 'host' || $name === 'port' || $name === 'headers' || $name === 'cookies' || $name === 'data' || $name === 'files';
    }

}
