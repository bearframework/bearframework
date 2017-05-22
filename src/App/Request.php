<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Provides information about the current request.
 * 
 * @property string|null $method The request method.
 * @property string|null $base The base URL of the request.
 * @property string|null $scheme The request scheme.
 * @property string|null $host The request hostname.
 * @property int|null $port The request port.
 * @property-read \BearFramework\App\Request\PathRepository $path The request path.
 * @property-read \BearFramework\App\Request\QueryRepository $query The request query string.
 * @property-read \BearFramework\App\Request\HeadersRepository $headers The request headers.
 * @property-read \BearFramework\App\Request\CookiesRepository $cookies The request cookies.
 * @property-read \BearFramework\App\Request\FormDataRepository $formData The request POST data and files.
 */
class Request
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param bool $initializeFromEnvironment Populate the object with information from the PHP environment.
     */
    public function __construct(bool $initializeFromEnvironment = false)
    {

        $this->defineProperty('method', [
            'type' => '?string'
        ]);

        $this->defineProperty('base', [
            'type' => '?string'
        ]);

        $updateBase = function($name, $value) {
            $data = parse_url($this->base);
            $this->base = ($name === 'scheme' ? $value : (isset($data['scheme']) ? $data['scheme'] : '')) . '://' . ($name === 'host' ? $value : (isset($data['host']) ? $data['host'] : '')) . ($name === 'port' ? (strlen($value) > 0 ? ':' . $value : '') : (isset($data['port']) ? ':' . $data['port'] : '')) . (isset($data['path']) ? $data['path'] : '');
        };

        $this->defineProperty('scheme', [
            'type' => '?string',
            'get' => function() {
                $data = parse_url($this->base);
                return isset($data['scheme']) ? $data['scheme'] : null;
            },
            'set' => function($value) use (&$updateBase) {
                $updateBase('scheme', $value);
            },
            'unset' => function() use (&$updateBase) {
                $updateBase('scheme', '');
            }
        ]);

        $this->defineProperty('host', [
            'type' => '?string',
            'get' => function() {
                $data = parse_url($this->base);
                return isset($data['host']) ? $data['host'] : null;
            },
            'set' => function($value) use (&$updateBase) {
                $updateBase('host', $value);
            },
            'unset' => function() use (&$updateBase) {
                $updateBase('host', '');
            }
        ]);

        $this->defineProperty('port', [
            'type' => '?int',
            'get' => function() {
                $data = parse_url($this->base);
                return isset($data['port']) ? $data['port'] : null;
            },
            'set' => function($value) use (&$updateBase) {
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
                    return new App\Request\PathRepository(isset($path{0}) ? $path : '/');
                },
                'readonly' => true
            ]);
            $this->defineProperty('query', [
                'init' => function() {
                    $query = new App\Request\QueryRepository();
                    $walkVariables = function($variables, $parent = null) use (&$query, &$walkVariables) {
                                foreach ($variables as $name => $value) {
                                    if (is_array($value)) {
                                        $walkVariables($value, $name);
                                        continue;
                                    }
                                    $query->set($query->make($parent === null ? $name : $parent . '[' . $name . ']', $value));
                                }
                            };
                    $walkVariables($_GET);
                    return $query;
                },
                'readonly' => true
            ]);
            $this->defineProperty('headers', [
                'init' => function() {
                    $headers = new App\Request\HeadersRepository();
                    foreach ($_SERVER as $name => $value) {
                        if (substr($name, 0, 5) == 'HTTP_') {
                            $headers->set($headers->make(str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))), $value));
                        }
                    }
                    return $headers;
                },
                'readonly' => true
            ]);
            $this->defineProperty('cookies', [
                'init' => function() {
                    $cookies = new App\Request\CookiesRepository();
                    foreach ($_COOKIE as $name => $value) {
                        $cookies->set($cookies->make($name, $value));
                    }
                    return $cookies;
                },
                'readonly' => true
            ]);
            $this->defineProperty('formData', [
                'init' => function() {
                    $data = new App\Request\FormDataRepository();
                    $walkVariables = function($variables, $parent = null) use (&$data, &$walkVariables) {
                                foreach ($variables as $name => $value) {
                                    if (is_array($value)) {
                                        $walkVariables($value, $name);
                                        continue;
                                    }
                                    $data->set($data->make($parent === null ? $name : $parent . '[' . $name . ']', $value));
                                }
                            };
                    $walkVariables($_POST);
                    foreach ($_FILES as $name => $value) {
                        if (is_uploaded_file($value['tmp_name'])) {
                            if ($value['error'] !== UPLOAD_ERR_OK) {
                                throw new \Exception('File upload error (' . $value['error'] . ')');
                            }
                            $file = new \BearFramework\App\Request\FormDataFileItem();
                            $file->name = $name;
                            $file->value = $value['name'];
                            $file->filename = $value['tmp_name'];
                            $file->size = $value['size'];
                            $file->type = $value['type'];
                            $data->set($file);
                        }
                    }
                    return $data;
                },
                'readonly' => true
            ]);
        } else {
            $this->defineProperty('path', [
                'init' => function() {
                    return new App\Request\PathRepository();
                },
                'readonly' => true
            ]);
            $this->defineProperty('query', [
                'init' => function() {
                    return new App\Request\QueryRepository();
                },
                'readonly' => true
            ]);
            $this->defineProperty('headers', [
                'init' => function() {
                    return new App\Request\HeadersRepository();
                },
                'readonly' => true
            ]);
            $this->defineProperty('cookies', [
                'init' => function() {
                    return new App\Request\CookiesRepository();
                },
                'readonly' => true
            ]);
            $this->defineProperty('formData', [
                'init' => function() {
                    return new App\Request\FormDataRepository();
                },
                'readonly' => true
            ]);
        }
    }

}
