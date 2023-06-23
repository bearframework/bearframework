<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
 * @property-read \BearFramework\App\Request\Path $path The request path.
 * @property-read \BearFramework\App\Request\Query $query The request query string.
 * @property-read \BearFramework\App\Request\Headers $headers The request headers.
 * @property-read \BearFramework\App\Request\Cookies $cookies The request cookies.
 * @property-read \BearFramework\App\Request\FormData $formData The request POST data and files.
 * @property-read \BearFramework\App\Request\Client $client Client data.
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
        $updateBase = function ($base, $name, $value): string {
            if ($base !== null) {
                $data =  parse_url($base);
                if (empty($data)) {
                    $schemeSeparatorIndex = strpos($base, '://');
                    if ($schemeSeparatorIndex !== false) {
                        $data = ['scheme' => substr($base, 0, $schemeSeparatorIndex)];
                    }
                }
            } else {
                $data = [];
            }
            return ($name === 'scheme' ? $value : (isset($data['scheme']) ? $data['scheme'] : '')) . '://' . ($name === 'host' ? $value : (isset($data['host']) ? $data['host'] : '')) . ($name === 'port' ? ($value !== null && strlen($value) > 0 ? ':' . $value : '') : (isset($data['port']) ? ':' . $data['port'] : '')) . (isset($data['path']) ? $data['path'] : '');
        };

        $preventBaseUpdate = false;
        $setBasePart = function ($name, $value) use (&$updateBase, &$preventBaseUpdate) {
            $preventBaseUpdate = true;
            $this->base = $updateBase($this->base, $name, $value);
            $preventBaseUpdate = false;
        };

        $this
            ->defineProperty('method', [
                'type' => '?string'
            ])
            ->defineProperty('base', [
                'type' => '?string',
                'set' => function ($value) use (&$updateBase, &$preventBaseUpdate) {
                    if ($preventBaseUpdate) {
                        return $value;
                    }
                    return $updateBase($value, '', '');
                },
            ])
            ->defineProperty('scheme', [
                'type' => '?string',
                'get' => function () {
                    $data = $this->base !== null ? parse_url($this->base) : [];
                    return isset($data['scheme']) ? $data['scheme'] : null;
                },
                'set' => function ($value) use (&$setBasePart) {
                    $setBasePart('scheme', $value);
                },
                'unset' => function () use (&$setBasePart) {
                    $setBasePart('scheme', '');
                }
            ])
            ->defineProperty('host', [
                'type' => '?string',
                'get' => function () {
                    $data = $this->base !== null ? parse_url($this->base) : [];
                    return isset($data['host']) ? $data['host'] : null;
                },
                'set' => function ($value) use (&$setBasePart) {
                    $setBasePart('host', $value);
                },
                'unset' => function () use (&$setBasePart) {
                    $setBasePart('host', '');
                }
            ])
            ->defineProperty('port', [
                'type' => '?int',
                'get' => function () {
                    $data = $this->base !== null ? parse_url($this->base) : [];
                    return isset($data['port']) ? $data['port'] : null;
                },
                'set' => function ($value) use (&$setBasePart) {
                    $setBasePart('port', $value);
                },
                'unset' => function () use (&$setBasePart) {
                    $setBasePart('port', '');
                }
            ]);

        $path = '';
        if ($initializeFromEnvironment && isset($_SERVER)) {
            $this->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
            $path = isset($_SERVER['REQUEST_URI']) && strlen($_SERVER['REQUEST_URI']) > 0 ? $_SERVER['REQUEST_URI'] : '/';
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
            // TODO: Remove X_FORWARDED in v2. Let the app decide to use them. Maybe add helper function
            $scheme = (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTP_X_FORWARDED_PROTOCOL']) && $_SERVER['HTTP_X_FORWARDED_PROTOCOL'] === 'https') || (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
            $host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'unknown';
            $port = isset($_SERVER['HTTP_X_FORWARDED_PORT']) ? $_SERVER['HTTP_X_FORWARDED_PORT'] : (isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : '');
            if ($scheme === 'http' && $port === '80') {
                $port = '';
            } elseif ($scheme === 'https' && $port === '443') {
                $port = '';
            }
            $this->base = $scheme . '://' . $host . ($port !== '' ? ':' . $port : '') . $basePath;
        }

        $this
            ->defineProperty('path', [
                'init' => function () use ($path) {
                    return new App\Request\Path(isset($path[0]) ? rawurldecode($path) : '/');
                },
                'readonly' => true
            ])
            ->defineProperty('query', [
                'init' => function () use ($initializeFromEnvironment) {
                    if ($initializeFromEnvironment && isset($_GET)) {
                        return App\Request\Query::fromArray($_GET);
                    }
                    return new App\Request\Query();
                },
                'readonly' => true
            ])
            ->defineProperty('headers', [
                'init' => function () use ($initializeFromEnvironment) {
                    $headers = new App\Request\Headers();
                    if ($initializeFromEnvironment && isset($_SERVER)) {
                        foreach ($_SERVER as $name => $value) {
                            if (substr($name, 0, 5) === 'HTTP_') {
                                $headers->set($headers->make(str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))), $value));
                            }
                        }
                    }
                    return $headers;
                },
                'readonly' => true
            ])
            ->defineProperty('cookies', [
                'init' => function () use ($initializeFromEnvironment) {
                    $cookies = new App\Request\Cookies();
                    if ($initializeFromEnvironment && isset($_COOKIE)) {
                        $stringifyKeys = function ($rawCookies, $level = 0) use (&$stringifyKeys) {
                            $result = [];
                            foreach ($rawCookies as $name => $value) {
                                $name = (string) $name;
                                if (is_array($value)) {
                                    $temp = $stringifyKeys($value, $level + 1);
                                    foreach ($temp as $subKey => $subValue) {
                                        $result[($level === 0 ? $name : '[' . $name . ']') . $subKey] = $subValue;
                                    }
                                } else {
                                    $result[($level === 0 ? $name : '[' . $name . ']')] = (string) $value;
                                }
                            }
                            return $result;
                        };
                        $stringifiedCookies = $stringifyKeys($_COOKIE);
                        foreach ($stringifiedCookies as $name => $value) {
                            $cookies->set($cookies->make((string) $name, (string) $value));
                        }
                    }
                    return $cookies;
                },
                'readonly' => true
            ])
            ->defineProperty('formData', [
                'init' => function () use ($initializeFromEnvironment) {
                    $data = new App\Request\FormData();
                    if ($initializeFromEnvironment && isset($_POST, $_FILES)) {
                        $walkVariables = function ($variables, $parent = null) use (&$data, &$walkVariables) {
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
                    }
                    return $data;
                },
                'readonly' => true
            ])
            ->defineProperty('client', [
                'init' => function () use ($path) {
                    $client = new App\Request\Client();
                    if (isset($_SERVER['REMOTE_ADDR'])) {
                        $client->ip = $_SERVER['REMOTE_ADDR'];
                    }
                    return $client;
                },
                'readonly' => true
            ]);
    }

    /**
     * Sets a new URL and overwrites the base, scheme, host, port, path and query properties.
     * 
     * @param string $url
     * @return self Returns a reference to itself.
     */
    public function setURL(string $url): self
    {
        $data = parse_url($url);
        $scheme = isset($data['scheme']) ? $data['scheme'] : 'http';
        $host = isset($data['host']) ? $data['host'] : 'unknown';
        $port = isset($data['port']) ? $data['port'] : '';
        $this->base = $scheme . '://' . $host . ($port !== '' ? ':' . $port : '');
        $this->path->set(isset($data['path']) ? $data['path'] : '');
        $this->query->deleteAll();
        if (isset($data['query'])) {
            $queryData = [];
            parse_str($data['query'], $queryData);
            $query = App\Request\Query::fromArray($queryData);
            $queryList = $query->getList();
            foreach ($queryList as $queryItem) {
                $this->query->set($queryItem);
            }
        }
        return $this;
    }

    /**
     * Returns the request URL or null if the base is empty.
     * 
     * @return string|null Returns the request URL or null if the base is empty.
     */
    public function getURL(): ?string
    {
        if ($this->base !== null) {
            $list = [];
            $queryList = $this->query->getList();
            foreach ($queryList as $queryItem) {
                $list[$queryItem->name] = $queryItem->value;
            }
            return $this->base . implode('/', array_map('rawurlencode', explode('/', (string) $this->path))) . (empty($list) ? '' : '?' . http_build_query($list));
        }
        return null;
    }
}
