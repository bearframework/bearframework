<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * The is the class used to instantiate you application.
 * 
 * @property-read \BearFramework\App\Request $request Provides information about the current request.
 * @property-read \BearFramework\App\Routes $routes Stores the data about the defined routes callbacks.
 * @property-read \BearFramework\App\Logs $logs Provides logging functionality.
 * @property-read \BearFramework\App\Addons $addons Provides a way to enable addons and manage their options.
 * @property-read \BearFramework\App\Assets $assets Provides utility functions for assets.
 * @property-read \BearFramework\App\DataRepository $data A file-based data storage.
 * @property-read \BearFramework\App\CacheRepository $cache Data cache.
 * @property-read \BearFramework\App\Classes $classes Provides functionality for registering and autoloading classes.
 * @property-read \BearFramework\App\URLs $urls URLs utilities.
 * @property-read \BearFramework\App\Contexts $contexts Provides information about your code context (the directory its located).
 * @property-read \BearFramework\App\Shortcuts $shortcuts Allow registration of $app object properties (shortcuts).
 * @event \Bearframework\App\BeforeSendResponseEvent beforeSendResponse An event dispatched before the response is sent to the client.
 * @event \BearFramework\App\SendResponseEvent sendResponse An event dispatched after the response is sent to the client.
 */
class App
{

    use \IvoPetkov\DataObjectTrait;
    use \BearFramework\EventsTrait;

    /**
     * The instance of the App object. Only one can be created.
     * 
     * @var \BearFramework\App 
     */
    private static $instance = null;

    /**
     * Information about whether the error handler is enabled.
     * 
     * @var bool 
     */
    private $errorHandlerEnabled = false;

    /**
     * 
     * @throws \Exception
     */
    public function __construct()
    {
        if (self::$instance !== null) {
            throw new \Exception('App already constructed');
        }
        self::$instance = &$this;

        $this
            ->defineProperty('request', [
                'init' => function () {
                    return new App\Request(true);
                },
                'type' => 'BearFramework\App\Request'
            ])
            ->defineProperty('routes', [
                'init' => function () {
                    return new App\Routes();
                },
                'readonly' => true
            ])
            ->defineProperty('logs', [
                'init' => function () {
                    return new App\Logs();
                },
                'readonly' => true
            ])
            ->defineProperty('addons', [
                'init' => function () {
                    return new App\Addons($this);
                },
                'readonly' => true
            ])
            ->defineProperty('assets', [
                'init' => function () {
                    return new App\Assets($this);
                },
                'readonly' => true
            ])
            ->defineProperty('data', [
                'init' => function () {
                    return new App\DataRepository(['filenameProtocol' => 'appdata']);
                },
                'readonly' => true
            ])
            ->defineProperty('cache', [
                'init' => function () {
                    return new App\CacheRepository();
                },
                'readonly' => true
            ])
            ->defineProperty('classes', [
                'init' => function () {
                    return new App\Classes();
                },
                'readonly' => true
            ])
            ->defineProperty('urls', [
                'init' => function () {
                    return new App\URLs($this);
                },
                'readonly' => true
            ])
            ->defineProperty('contexts', [
                'init' => function () {
                    return new App\Contexts($this);
                },
                'readonly' => true
            ])
            ->defineProperty('shortcuts', [
                'init' => function () {
                    return new App\Shortcuts(function (string $name, callable $callback) {
                        if (isset($this->$name)) {
                            throw new \Exception('A property/shortcut named "' . $name . '" already exists!');
                        }
                        $this->defineProperty($name, [
                            'init' => $callback,
                            'readonly' => true
                        ]);
                    });
                },
                'readonly' => true
            ]);
    }

    /**
     * Returns the application instance.
     * 
     * @return \BearFramework\App The application instance.
     * @throws \Exception
     */
    static function get(): \BearFramework\App
    {
        if (self::$instance === null) {
            throw new \Exception('App is not constructed yet');
        }
        return self::$instance;
    }

    /**
     * Enables an error handler.
     * 
     * @param array $options Error handler options. Available values: logErrors (bool), displayErrors (bool).
     * @return void No value is returned.
     * @throws \Exception
     */
    public function enableErrorHandler(array $options = []): void
    {
        if ($this->errorHandlerEnabled) {
            throw new \Exception('The error handler is already enabled!');
        }
        set_exception_handler(function ($exception) use ($options) {
            \BearFramework\Internal\ErrorHandler::handleException($this, $exception, $options);
        });
        register_shutdown_function(function () use ($options) {
            $errorData = error_get_last();
            if (is_array($errorData)) {
                \BearFramework\Internal\ErrorHandler::handleFatalError($this, $errorData, $options);
            }
        });
        set_error_handler(function ($errorNumber, $errorMessage, $errorFile, $errorLine) {
            throw new \ErrorException($errorMessage, 0, $errorNumber, $errorFile, $errorLine);
        });
        $this->errorHandlerEnabled = true;
    }

    /**
     * Call this method to find the response in the registered routes and send it.
     * 
     * @return void No value is returned.
     */
    public function run(): void
    {
        $response = $this->routes->getResponse($this->request);
        if (!($response instanceof App\Response)) {
            $response = new App\Response\NotFound();
        }
        $this->send($response);
    }

    /**
     * Outputs a response.
     * 
     * @param \BearFramework\App\Response $response The response object to output.
     * @return void No value is returned.
     */
    public function send(\BearFramework\App\Response $response): void
    {
        if ($this->hasEventListeners('beforeSendResponse')) {
            $this->dispatchEvent('beforeSendResponse', new \BearFramework\App\BeforeSendResponseEventDetails($response));
        }
        if (!$response->headers->exists('Content-Length')) {
            $response->headers->set($response->headers->make('Content-Length', ($response instanceof App\Response\FileReader ? (string) filesize($response->filename) : (string) strlen($response->content))));
        }
        $rangeHeaderValue = $response->headers->getValue('Accept-Ranges') === 'bytes' ? $this->request->headers->getValue('Range') : null;
        if ($rangeHeaderValue !== null) {
            $rangeStart = null;
            $rangeEnd = null;
            $matches = null;
            if (preg_match('/^bytes=(\d+)?-(\d+)?$/i', $rangeHeaderValue, $matches)) {
                $contentLength = $response->headers->getValue('Content-Length');
                $rangeStart = strlen($matches[1]) > 0 ? (int) $matches[1] : null;
                if (isset($matches[2])) {
                    $rangeEnd = (int) $matches[2];
                    if ($rangeStart === null) {
                        $rangeStart = $contentLength - $rangeEnd;
                        if ($rangeStart < 0) {
                            $rangeStart = 0;
                        }
                        $rangeEnd = $rangeStart + $rangeEnd - 1;
                    }
                    if ($rangeEnd >= $contentLength) {
                        $rangeEnd = $contentLength - 1;
                    }
                } else {
                    $rangeEnd = $contentLength - 1;
                }
                $response->statusCode = 206;
                $response->headers->set($response->headers->make('Content-Range', 'bytes ' . $rangeStart . '-' . $rangeEnd . '/' . $contentLength));
                $response->headers->set($response->headers->make('Content-Length', $rangeEnd - $rangeStart + 1));
            }
        }
        if (!$response->headers->exists('Cache-Control')) {
            $response->headers->set($response->headers->make('Cache-Control', 'no-cache, no-store, must-revalidate, private, max-age=0'));
        }
        http_response_code($response->statusCode);
        if (!headers_sent()) {
            $headers = $response->headers->getList();
            foreach ($headers as $header) {
                if ($header->name === 'Content-Type' && $response->charset !== null) {
                    $header->value .= '; charset=' . $response->charset;
                }
                header($header->name . ': ' . $header->value);
            }
            $cookies = $response->cookies->getList();
            if ($cookies->count() > 0) {
                $baseURLParts = parse_url($this->request->base);
                foreach ($cookies as $cookie) {
                    setcookie($cookie->name, $cookie->value, $cookie->expire, $cookie->path === null ? (isset($baseURLParts['path']) ? $baseURLParts['path'] . '/' : '/') : $cookie->path, $cookie->domain === null ? (isset($baseURLParts['host']) ? $baseURLParts['host'] : '') : $cookie->domain, $cookie->secure === null ? $this->request->scheme === 'https' : $cookie->secure, $cookie->httpOnly);
                }
            }
        }
        if ($rangeHeaderValue !== null && $rangeStart !== null) {
            if ($response instanceof App\Response\FileReader) {
                $handle = fopen($response->filename, 'rb');
                if (fseek($handle, $rangeStart, SEEK_SET) === -1) {
                    throw new \Exception('Cannot set offset to ' . $rangeStart . '!');
                }
                $buffer = '';
                $bytesLeftToRead = $rangeEnd - $rangeStart + 1;
                while ($bytesLeftToRead > 0) {
                    $buffer = fread($handle, min(16384, $bytesLeftToRead));
                    $bytesRead = strlen($buffer);
                    if ($bytesRead === 0) { // something is wrong
                        break;
                    }
                    $bytesLeftToRead -= $bytesRead;
                    echo $buffer;
                    flush();
                }
                fclose($handle);
            } else {
                echo substr($response->content, $rangeStart, $rangeEnd - $rangeStart + 1);
            }
        } else {
            if ($response instanceof App\Response\FileReader) {
                readfile($response->filename);
            } else {
                echo $response->content;
            }
        }
        if ($this->hasEventListeners('sendResponse')) {
            $this->dispatchEvent('sendResponse', new \BearFramework\App\SendResponseEventDetails($response));
        }
    }

    /**
     * Prevents multiple application instances.
     * 
     * @throws \Exception
     * @return void No value is returned.
     */
    public function __clone()
    {
        throw new \Exception('Cannot have multiple App instances');
    }

    /**
     * Prevents multiple application instances.
     * 
     * @throws \Exception
     * @return void No value is returned.
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot have multiple App instances');
    }
}
