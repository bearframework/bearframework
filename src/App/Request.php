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
 * @property-read \BearFramework\App\Request\Path $path The request path
 * @property-read \BearFramework\App\Request\Query $query The request query string
 * @property-read \BearFramework\App\Request\Headers $headers The request headers
 * @property-read \BearFramework\App\Request\Cookies $cookies The request cookies
 * @property-read \BearFramework\App\Request\Data $data The request POST data
 * @property-read \BearFramework\App\Request\Files $files The request files data
 */
class Request
{

    use \IvoPetkov\DataObjectTrait;

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
    public function __construct($initializeFromEnvironment = false)
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

        if ($initializeFromEnvironment && isset($_SERVER)) {
            $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
            $path = isset($_SERVER['REQUEST_URI']) && strlen($_SERVER['REQUEST_URI']) > 0 ? urldecode($_SERVER['REQUEST_URI']) : '/';
            $position = strpos($path, '?');
            if ($position !== false) {
                $path = substr($path, 0, $position);
            }
            $basePath = '';
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $scriptName = $_SERVER['SCRIPT_NAME'];
                if (strpos($path, $scriptName) === 0) {
                    $basePath = $scriptName;
                    $path = substr($path, strlen($scriptName));
                } else {
                    $pathInfo = pathinfo($_SERVER['SCRIPT_NAME']);
                    $dirName = $pathInfo['dirname'];
                    if ($dirName === DIRECTORY_SEPARATOR || $dirName === '.') {
                        $basePath = '';
                        $path = $path;
                    } else {
                        $basePath = $dirName;
                        $path = substr($path, strlen($dirName));
                    }
                }
            }
            $scheme = (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTP_X_FORWARDED_PROTOCOL']) && $_SERVER['HTTP_X_FORWARDED_PROTOCOL'] === 'https') || (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
            $host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'unknown';
            $port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : '';
            $this->base = $scheme . '://' . $host . ($port !== '' && $port !== '80' ? ':' . $port : '') . $basePath;

            $this->defineProperty('path', [
                'init' => function() use ($path) {
                    return new App\Request\Path(isset($path{0}) ? $path : '/');
                },
                'readonly' => true
            ]);
            $this->defineProperty('query', [
                'init' => function() {
                    $query = new App\Request\Query();
                    foreach ($_GET as $name => $value) {
                        $query->set($name, $value);
                    }
                    return $query;
                },
                'readonly' => true
            ]);
            $this->defineProperty('headers', [
                'init' => function() {
                    $headers = new App\Request\Headers();
                    foreach ($_SERVER as $name => $value) {
                        if (substr($name, 0, 5) == 'HTTP_') {
                            $headers->set(str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))), $value);
                        }
                    }
                    return $headers;
                },
                'readonly' => true
            ]);
            $this->defineProperty('cookies', [
                'init' => function() {
                    $cookies = new App\Request\Cookies();
                    foreach ($_COOKIE as $name => $value) {
                        $cookies->set($name, $value);
                    }
                    return $cookies;
                },
                'readonly' => true
            ]);
            $this->defineProperty('data', [
                'init' => function() {
                    $data = new App\Request\Data();
                    foreach ($_POST as $name => $value) {
                        $data->set($name, $value);
                    }
                    return $data;
                },
                'readonly' => true
            ]);
            $this->defineProperty('files', [
                'init' => function() {
                    $files = new App\Request\Files();
                    foreach ($_FILES as $name => $value) {
                        if (is_uploaded_file($value['tmp_name'])) {
                            $files->set($name, $value['name'], $value['tmp_name'], $value['size'], $value['type'], $value['error']);
                        }
                    }
                    return $files;
                },
                'readonly' => true
            ]);
        } else {
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
