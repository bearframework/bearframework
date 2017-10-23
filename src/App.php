<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

use BearFramework\App;

/**
 * The is the class used to instantiate and configure you application.
 * 
 * @property-read \BearFramework\App\Config $config The application configuration.
 * @property-read \BearFramework\App\Container $container Services container.
 * @property-read \BearFramework\App\Request $request Provides information about the current request.
 * @property-read \BearFramework\App\RoutesRepository $routes Stores the data about the defined routes callbacks.
 * @property-read \BearFramework\App\ILogger $logger Provides logging functionality.
 * @property-read \BearFramework\App\AddonsRepository $addons Provides a way to enable addons and manage their options.
 * @property-read \BearFramework\App\HooksRepository $hooks Provides functionality for notifications and executing custom code.
 * @property-read \BearFramework\App\Assets $assets Provides utility functions for assets.
 * @property-read \BearFramework\App\DataRepository $data A file-based data storage.
 * @property-read \BearFramework\App\CacheRepository $cache Data cache.
 * @property-read \BearFramework\App\ClassesRepository $classes Provides functionality for registering and autoloading classes.
 * @property-read \BearFramework\App\Urls $urls URLs utilities.
 * @property-read \BearFramework\App\Images $images Images utilities.
 * @property-read \BearFramework\App\ContextsRepository $context Provides information about your code context (is it in the app dir, or is it in an addon dir).
 * @property-read \BearFramework\App\ShortcutsRepository $shortcuts Allow registration of $app object properties (shortcuts).
 */
class App
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * Current Bear Framework version.
     * 
     * @var string
     */
    const VERSION = 'dev';

    /**
     * The instance of the App object. Only one can be created.
     * 
     * @var \BearFramework\App 
     */
    private static $instance = null;

    /**
     * Information about whether the application is initialized.
     * 
     * @var bool 
     */
    private $initialized = false;

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

        $this->defineProperty('config', [
            'init' => function() {
                return new App\Config();
            },
            'readonly' => true
        ]);
        $this->defineProperty('container', [
            'init' => function() {
                $container = new App\Container();
                $container->set('Logger', function() {
                            if ($this->config->logsDir === null) {
                                throw new \Exception('The value of the logsDir config variable is empty.');
                            }
                            return new App\DefaultLogger($this->config->logsDir);
                        });
                $container->set('CacheDriver', App\DefaultCacheDriver::class);
                return $container;
            },
            'readonly' => true
        ]);
        $this->defineProperty('request', [
            'init' => function() {
                return new App\Request(true);
            },
            'readonly' => true
        ]);
        $this->defineProperty('routes', [
            'init' => function() {
                $routes = new App\RoutesRepository();
                $routes->add($this->config->assetsPathPrefix . '*', function() {
                            $response = $this->assets->getResponse($this->request);
                            if ($response !== null) {
                                return $response;
                            }
                        });
                return $routes;
            },
            'readonly' => true
        ]);
        $this->defineProperty('logger', [
            'init' => function() {
                return $this->container->get('Logger');
            },
            'readonly' => true
        ]);
        $this->defineProperty('addons', [
            'init' => function() {
                return new App\AddonsRepository();
            },
            'readonly' => true
        ]);
        $this->defineProperty('hooks', [
            'init' => function() {
                return new App\HooksRepository();
            },
            'readonly' => true
        ]);
        $this->defineProperty('assets', [
            'init' => function() {
                return new App\Assets();
            },
            'readonly' => true
        ]);
        $this->defineProperty('data', [
            'init' => function() {
                if ($this->config->dataDir === null) {
                    throw new \Exception('The value of the dataDir config variable is empty.');
                }
                return new App\DataRepository($this->config->dataDir);
            },
            'readonly' => true
        ]);
        $this->defineProperty('cache', [
            'init' => function() {
                return new App\CacheRepository($this->container->get('CacheDriver'));
            },
            'readonly' => true
        ]);
        $this->defineProperty('classes', [
            'init' => function() {
                return new App\ClassesRepository();
            },
            'readonly' => true
        ]);
        $this->defineProperty('urls', [
            'init' => function() {
                return new App\Urls();
            },
            'readonly' => true
        ]);
        $this->defineProperty('images', [
            'init' => function() {
                return new App\Images();
            },
            'readonly' => true
        ]);
        $this->defineProperty('context', [
            'init' => function() {
                return new App\ContextsRepository();
            },
            'readonly' => true
        ]);
        $this->defineProperty('shortcuts', [
            'init' => function() {
                $initPropertyMethod = function($callback) { // needed to preserve the $this context
                            return $callback();
                        };
                $addPropertyMethod = function($name, $callback) use (&$initPropertyMethod) {
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
     * @return \BearFramework\App
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
     * Initializes the environment, the error handlers and includes the application index.php file.
     * 
     * @return void No value is returned
     */
    public function initialize(): void
    {
        if (!$this->initialized) {
            // @codeCoverageIgnoreStart
            if ($this->config->updateEnvironment) {
                if (version_compare(PHP_VERSION, '7.2.0', '<')) {
                    ini_set('mbstring.func_overload', 7);
                }
                ini_set("pcre.backtrack_limit", 100000000);
                ini_set("pcre.recursion_limit", 100000000);
            }
            if ($this->config->handleErrors) {
                set_exception_handler(function($exception) {
                    \BearFramework\App\ErrorHandler::handleException($exception);
                });
                register_shutdown_function(function() {
                    $errorData = error_get_last();
                    if (is_array($errorData)) {
                        \BearFramework\App\ErrorHandler::handleFatalError($errorData);
                    }
                });
                set_error_handler(function($errorNumber, $errorMessage, $errorFile, $errorLine) {
                    throw new \ErrorException($errorMessage, 0, $errorNumber, $errorFile, $errorLine);
                });
            }
            // @codeCoverageIgnoreEnd

            $this->initialized = true;

            if (strlen($this->config->appDir) > 0) {
                $indexFilename = realpath($this->config->appDir . DIRECTORY_SEPARATOR . 'index.php');
                if ($indexFilename !== false) {
                    ob_start();
                    try {
                        (static function($__filename) {
                            include $__filename;
                        })($indexFilename);
                        ob_end_clean();
                    } catch (\Exception $e) {
                        ob_end_clean();
                        throw $e;
                    }
                }
            }

            $this->hooks->execute('initialized');
        }
    }

    /**
     * Call this method to execute the application. This method initializes the applications and outputs the response.
     * 
     * @return void No value is returned.
     */
    public function run(): void
    {
        $this->initialize();
        $response = $this->routes->getResponse($this->request);
        if (!($response instanceof App\Response)) {
            $response = new App\Response\NotFound();
        }
        $this->respond($response);
    }

    /**
     * Outputs a response.
     * 
     * @param \BearFramework\App\Response $response The response object to output.
     * @return void No value is returned.
     */
    public function respond(\BearFramework\App\Response $response): void
    {
        $this->hooks->execute('responseCreated', $response);
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
        $this->hooks->execute('responseSent', $response);
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
