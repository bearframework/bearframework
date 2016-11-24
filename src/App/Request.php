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

    use \BearFramework\App\DynamicProperties;

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
     * The constructor
     */
    public function __construct()
    {

        $updateBase = function($name, $value) {
            $data = parse_url($this->base);
            $this->base = ($name === 'scheme' ? $value : (isset($data['scheme']) ? $data['scheme'] : '')) . '://' . ($name === 'host' ? $value : (isset($data['host']) ? $data['host'] : '')) . ($name === 'port' ? (strlen($value) > 0 ? ':' . $value : '') : (isset($data['port']) ? ':' . $data['port'] : '')) . (isset($data['path']) ? $data['path'] : '');
        };

        $this->defineProperty('scheme', [
            'get' => function() {
                $data = parse_url($this->base);
                return isset($data['scheme']) ? $data['scheme'] : null;
            },
            'set' => function($value) use (&$updateBase) {
                if (!is_string($value)) {
                    throw new \InvalidArgumentException('The value of the scheme property must be of type string');
                }
                $updateBase('scheme', $value);
            },
            'unset' => function() use (&$updateBase) {
                $updateBase('scheme', '');
            }
        ]);

        $this->defineProperty('host', [
            'get' => function() {
                $data = parse_url($this->base);
                return isset($data['host']) ? $data['host'] : null;
            },
            'set' => function($value) use (&$updateBase) {
                if (!is_string($value)) {
                    throw new \InvalidArgumentException('The value of the host property must be of type string');
                }
                $updateBase('host', $value);
            },
            'unset' => function() use (&$updateBase) {
                $updateBase('host', '');
            }
        ]);

        $this->defineProperty('port', [
            'get' => function() {
                $data = parse_url($this->base);
                return isset($data['port']) ? $data['port'] : null;
            },
            'set' => function($value) use (&$updateBase) {
                if (!((is_string($value) && preg_match('/^[0-9]*$/', $value) === 1) || (is_int($value) && $value > 0) || $value === null)) {
                    throw new \InvalidArgumentException('The value of the port property must be of type string (numeric), positve int or null');
                }
                $updateBase('port', $value);
            },
            'unset' => function() use (&$updateBase) {
                $updateBase('port', '');
            }
        ]);

        $this->defineProperty('path', [
            'init' => function() {
                return new App\Request\Path();
            },
            'readonly' => true
        ]);
        $this->defineProperty('query', [
            'init' => function() {
                return new App\Request\Query();
            },
            'readonly' => true
        ]);
        $this->defineProperty('headers', [
            'init' => function() {
               return new App\Request\Headers();
            },
            'readonly' => true
        ]);
        $this->defineProperty('cookies', [
            'init' => function() {
                return new App\Request\Cookies();
            },
            'readonly' => true
        ]);
        $this->defineProperty('data', [
            'init' => function() {
                return new App\Request\Data();
            },
            'readonly' => true
        ]);
        $this->defineProperty('files', [
            'init' => function() {
                return new App\Request\Files();
            },
            'readonly' => true
        ]);
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

}
