<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

use BearFramework\App;

/**
 * The is the class used to instantiate and configure you application.
 * 
 * @property-read \BearFramework\App\Config $config The application configuration.
 * @property-read \BearFramework\App\Request $request Provides information about the current request.
 * @property-read \BearFramework\App\RoutesRepository $routes Stores the data about the defined routes callbacks.
 * @property-read \BearFramework\App\LogsRepository $logs Provides logging functionality.
 * @property-read \BearFramework\App\AddonsRepository $addons Provides a way to enable addons and manage their options.
 * @property-read \BearFramework\App\Assets $assets Provides utility functions for assets.
 * @property-read \BearFramework\App\DataRepository $data A file-based data storage.
 * @property-read \BearFramework\App\CacheRepository $cache Data cache.
 * @property-read \BearFramework\App\ClassesRepository $classes Provides functionality for registering and autoloading classes.
 * @property-read \BearFramework\App\Urls $urls URLs utilities.
 * @property-read \BearFramework\App\ContextsRepository $context Provides information about your code context (the directory its located).
 * @property-read \BearFramework\App\ShortcutsRepository $shortcuts Allow registration of $app object properties (shortcuts).
 * @event \Bearframework\App\BeforeSendResponseEvent beforeSendResponse An event dispatched before the response is sent to the client.
 * @event \BearFramework\App\SendResponseEvent sendResponse An event dispatched after the response is sent to the client.
 */
class App
{

    use \IvoPetkov\DataObjectTrait;
    use \BearFramework\App\EventsTrait;

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
                ->defineProperty('config', [
                    'init' => function() {
                        return new App\Config();
                    },
                    'readonly' => true
                ])
                ->defineProperty('request', [
                    'init' => function() {
                        return new App\Request(true);
                    },
                    'readonly' => true
                ])
                ->defineProperty('routes', [
                    'init' => function() {
                        return new App\RoutesRepository();
                    },
                    'readonly' => true
                ])
                ->defineProperty('logs', [
                    'init' => function() {
                        return new App\LogsRepository();
                    },
                    'readonly' => true
                ])
                ->defineProperty('addons', [
                    'init' => function() {
                        return new App\AddonsRepository();
                    },
                    'readonly' => true
                ])
                ->defineProperty('assets', [
                    'init' => function() {
                        return new App\Assets();
                    },
                    'readonly' => true
                ])
                ->defineProperty('data', [
                    'init' => function() {
                        return new App\DataRepository(['filenameProtocol' => 'appdata']);
                    },
                    'readonly' => true
                ])
                ->defineProperty('cache', [
                    'init' => function() {
                        return new App\CacheRepository();
                    },
                    'readonly' => true
                ])
                ->defineProperty('classes', [
                    'init' => function() {
                        return new App\ClassesRepository();
                    },
                    'readonly' => true
                ])
                ->defineProperty('urls', [
                    'init' => function() {
                        return new App\Urls();
                    },
                    'readonly' => true
                ])
                ->defineProperty('context', [
                    'init' => function() {
                        return new App\ContextsRepository();
                    },
                    'readonly' => true
                ])
                ->defineProperty('shortcuts', [
                    'init' => function() {
                        $initPropertyMethod = function($callback) { // needed to preserve the $this context
                                    return $callback();
                                };
                        $addPropertyMethod = function($name, $callback) use (&$initPropertyMethod) {
                                    if (isset($this->$name)) {
                                        throw new \Exception('A property/shortcut named "' . $name . '" already exists!');
                                    }
                                    $this->defineProperty($name, [
                                        'init' => function() use (&$callback, &$initPropertyMethod) {
                                            return $initPropertyMethod($callback);
                                        },
                                        'readonly' => true
                                    ]);
                                };

                        return new class($addPropertyMethod) {

                            private $addPropertyMethod = null;

                            public function __construct($addPropertyMethod)
                            {
                                $this->addPropertyMethod = $addPropertyMethod;
                            }

                            public function add(string $name, callable $callback)
                            {
                                call_user_func($this->addPropertyMethod, $name, $callback);
                                return $this;
                            }
                        };
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
    public function enableErrorHandler(array $options): void
    {
        if ($this->errorHandlerEnabled) {
            throw new \Exception('The error handler is already enabled!');
        }
        set_exception_handler(function($exception) use ($options) {
            \BearFramework\App\ErrorHandler::handleException($exception, $options);
        });
        register_shutdown_function(function() use ($options) {
            $errorData = error_get_last();
            if (is_array($errorData)) {
                \BearFramework\App\ErrorHandler::handleFatalError($errorData, $options);
            }
        });
        set_error_handler(function($errorNumber, $errorMessage, $errorFile, $errorLine) {
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
            $this->dispatchEvent(new \BearFramework\App\BeforeSendResponseEvent($response));
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
            if ($cookies->length > 0) {
                $baseUrlParts = parse_url($this->request->base);
                foreach ($cookies as $cookie) {
                    setcookie($cookie->name, $cookie->value, $cookie->expire, $cookie->path === null ? (isset($baseUrlParts['path']) ? $baseUrlParts['path'] . '/' : '/') : $cookie->path, $cookie->domain === null ? (isset($baseUrlParts['host']) ? $baseUrlParts['host'] : '') : $cookie->domain, $cookie->secure === null ? $this->request->scheme === 'https' : $cookie->secure, $cookie->httpOnly);
                }
            }
        }
        if ($response instanceof App\Response\FileReader) {
            readfile($response->filename);
        } else {
            echo $response->content;
        }
        if ($this->hasEventListeners('sendResponse')) {
            $this->dispatchEvent(new \BearFramework\App\SendResponseEvent($response));
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
