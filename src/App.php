<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
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
 * @property-read \BearFramework\App\Logger $logger Provides logging functionality.
 * @property-read \BearFramework\App\AddonsRepository $addons Provides a way to enable addons and manage their options.
 * @property-read \BearFramework\App\HooksRepository $hooks Provides functionality for notifications and data requests.
 * @property-read \BearFramework\App\Assets $assets Provides utility functions for assets.
 * @property-read \BearFramework\App\DataRepository $data
 * @property-read \BearFramework\App\CacheRepository $cache Data cache.
 * @property-read \BearFramework\App\ClassesRepository $classes Provides functionality for autoloading classes.
 * @property-read \BearFramework\App\Urls $urls URLs utilities.
 * @property-read \BearFramework\App\Images $images Images utilities.
 * @property-read \BearFramework\App\ContextsRepository $context Context information object locator.
 * @property-read \BearFramework\App\ShortcutsRepository $shortcuts Allow registration of $app object properties (shortcuts).
 */
class App
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * Current Bear Framework version
     * 
     * @var string
     */
    const VERSION = 'dev';

    /**
     * Services container
     * 
     * @var \BearFramework\App\Container 
     */
    public $container = null;

    /**
     * The instance of the App object. Only one can be created.
     * 
     * @var \BearFramework\App 
     */
    private static $instance = null;

    /**
     * Information about whether the application is initialized
     * 
     * @var bool 
     */
    private $initialized = false;

    /**
     * The constructor
     * 
     * @throws \Exception
     */
    public function __construct()
    {
        if (self::$instance !== null) {
            throw new \Exception('App already constructed');
        }
        self::$instance = &$this;

        $this->container = new App\Container();
        $this->container->set('app.logger', App\Logger::class);
        $this->container->set('app.cache', App\CacheRepository::class);

        $this->defineProperty('config', [
            'init' => function() {
                return new App\Config();
            },
            'readonly' => true
        ]);
        $request = null;
        $this->defineProperty('request', [
            'get' => function() use (&$request) {
                if ($this->initialized) {
                    if ($request === null) {
                        $request = new App\Request(true);
                    }
                    return $request;
                }
                return null;
            },
            'readonly' => true
        ]);
        $this->defineProperty('routes', [
            'init' => function() {
                return new App\RoutesRepository();
            },
            'readonly' => true
        ]);
        $this->defineProperty('logger', [
            'get' => function() {
                return $this->container->get('app.logger');
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
                $assets = new App\Assets();
                if ($this->config->dataDir !== null) {
                    $dataAssetsDir = $this->config->dataDir . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
                    $assets->addDir($dataAssetsDir);
                    $this->hooks->add('prepareAsset', function($data) use ($dataAssetsDir) {
                                if (strpos($data->filename, $dataAssetsDir) === 0) {
                                    $key = str_replace('\\', '/', substr($data->filename, strlen($dataAssetsDir)));
                                    if ($this->data->isPublic($key)) {
                                        $data->filename = $this->data->getFilename($key);
                                    } else {
                                        $data->filename = null;
                                    }
                                }
                            });
                }
                return $assets;
            },
            'readonly' => true
        ]);
        $this->defineProperty('data', [
            'init' => function() {
                return new App\DataRepository();
            },
            'readonly' => true
        ]);
        $this->defineProperty('cache', [
            'get' => function() {
                return $this->container->get('app.cache');
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
                    }
                };
            },
            'readonly' => true
        ]);
    }

    /**
     * Returns the app instance
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
     * Initializes the environment, the error handlers, includes the app index.php file, the addons index.php files, and registers the assets handler
     */
    public function initialize(): void
    {
        if (!$this->initialized) {
            $this->initializeEnvironment();
            $this->initializeErrorHandler();

            $this->initialized = true; // The request property counts on this. It must be here so that app and addons index.php files can access it.

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

            if ($this->config->assetsPathPrefix !== null) {
                $this->routes->add($this->config->assetsPathPrefix . '*', function() {
                    return $this->assets->getResponse($this->request);
                });
            }

            $this->hooks->execute('initialized');
        }
    }

    /**
     * Sets UTF-8 as the default encoding and updates regular expressions limits
     */
    private function initializeEnvironment(): void
    {
        // @codeCoverageIgnoreStart
        if ($this->config->updateEnvironment) {
            ini_set('mbstring.func_overload', 7);
            ini_set("pcre.backtrack_limit", 100000000);
            ini_set("pcre.recursion_limit", 100000000);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Initializes error handling
     */
    private function initializeErrorHandler(): void
    {
        if ($this->config->handleErrors) {
            // @codeCoverageIgnoreStart
            $handleError = function($message, $file, $line, $trace) {
                if ($this->config->logErrors && strlen($this->config->logsDir) > 0) {
                    try {
                        $data = [];
                        $data['file'] = $file;
                        $data['line'] = $line;
                        $data['trace'] = $trace;
                        $data['GET'] = isset($_GET) ? $_GET : null;
                        $data['POST'] = isset($_POST) ? $_POST : null;
                        $data['SERVER'] = isset($_SERVER) ? $_SERVER : null;
                        $this->logger->log('error', $message, $data);
                    } catch (\Exception $e) {
                        
                    }
                }
                if ($this->config->displayErrors) {
                    if (ob_get_length() > 0) {
                        ob_clean();
                    }
                    $data = "Error:";
                    $data .= "\nMessage: " . $message;
                    $data .= "\nFile: " . $file;
                    $data .= "\nLine: " . $line;
                    $data .= "\nTrace: " . $trace;
                    $data .= "\nGET: " . print_r(isset($_GET) ? $_GET : null, true);
                    $data .= "\nPOST: " . print_r(isset($_POST) ? $_POST : null, true);
                    $data .= "\nSERVER: " . print_r(isset($_SERVER) ? $_SERVER : null, true);
                    $response = new App\Response\TemporaryUnavailable($data);
                } else {
                    $response = new App\Response\TemporaryUnavailable();
                    try {
                        $this->prepareResponse($response);
                    } catch (\Exception $e) {
                        // ignore
                    }
                }
                $this->sendResponse($response);
            };
            set_exception_handler(function($exception) use($handleError) {
                $handleError($exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTraceAsString());
            });
            register_shutdown_function(function() use($handleError) {
                $errorData = error_get_last();
                if (is_array($errorData)) {
                    if (ob_get_length() > 0) {
                        ob_end_clean();
                    }
                    $messageParts = explode(' in ' . $errorData['file'] . ':' . $errorData['line'], $errorData['message'], 2);
                    $handleError(trim($messageParts[0]), $errorData['file'], $errorData['line'], isset($messageParts[1]) ? trim(str_replace('Stack trace:', '', $messageParts[1])) : '');
                }
            });
            set_error_handler(function($errorNumber, $errorMessage, $errorFile, $errorLine) {
                throw new \ErrorException($errorMessage, 0, $errorNumber, $errorFile, $errorLine);
            });
            // @codeCoverageIgnoreEnd
        }
    }

    /**
     * Call this method to start the application. This method initializes the app and outputs the response.
     * 
     * @return void No value is returned
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
     * Prepares the response (hooks, validations and other operations)
     * 
     * @param \BearFramework\App\Response $response The response object to prepare
     * @return void No value is returned
     */
    private function prepareResponse(\BearFramework\App\Response $response): void
    {
        $this->hooks->execute('responseCreated', $response);
    }

    /**
     * Sends the response to the client
     * 
     * @param \BearFramework\App\Response $response The response object to be sent
     * @return void No value is returned
     */
    private function sendResponse(\BearFramework\App\Response $response): void
    {
        if (!headers_sent()) {
            $statusCodes = [];
            $statusCodes[200] = 'OK';
            $statusCodes[201] = 'Created';
            $statusCodes[202] = 'Accepted';
            $statusCodes[203] = 'Non-Authoritative Information';
            $statusCodes[204] = 'No Content';
            $statusCodes[205] = 'Reset Content';
            $statusCodes[206] = 'Partial Content';
            $statusCodes[300] = 'Multiple Choices';
            $statusCodes[301] = 'Moved Permanently';
            $statusCodes[302] = 'Found';
            $statusCodes[303] = 'See Other';
            $statusCodes[304] = 'Not Modified';
            $statusCodes[305] = 'Use Proxy';
            $statusCodes[307] = 'Temporary Redirect';
            $statusCodes[400] = 'Bad Request';
            $statusCodes[401] = 'Unauthorized';
            $statusCodes[402] = 'Payment Required';
            $statusCodes[403] = 'Forbidden';
            $statusCodes[404] = 'Not Found';
            $statusCodes[405] = 'Method Not Allowed';
            $statusCodes[406] = 'Not Acceptable';
            $statusCodes[407] = 'Proxy Authentication Required';
            $statusCodes[408] = 'Request Timeout';
            $statusCodes[409] = 'Conflict';
            $statusCodes[410] = 'Gone';
            $statusCodes[411] = 'Length Required';
            $statusCodes[412] = 'Precondition Failed';
            $statusCodes[413] = 'Request Entity Too Large';
            $statusCodes[414] = 'Request-URI Too Long';
            $statusCodes[415] = 'Unsupported Media Type';
            $statusCodes[416] = 'Requested Range Not Satisfiable';
            $statusCodes[417] = 'Expectation Failed';
            $statusCodes[500] = 'Internal Server Error';
            $statusCodes[501] = 'Not Implemented';
            $statusCodes[502] = 'Bad Gateway';
            $statusCodes[503] = 'Service Unavailable';
            $statusCodes[504] = 'Gateway Timeout';
            $statusCodes[505] = 'HTTP Version Not Supported';
            if (isset($statusCodes[$response->statusCode])) {
                header((isset($_SERVER, $_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1') . ' ' . $response->statusCode . ' ' . $statusCodes[$response->statusCode]);
            }
            $headers = $response->headers->getList();
            foreach ($headers as $header) {
                if ($header->name === 'Content-Type') {
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
     * Outputs a response
     * 
     * @param \BearFramework\App\Response $response The response object to output
     * @return void No value is returned
     */
    public function respond(\BearFramework\App\Response $response): void
    {
        $this->prepareResponse($response);
        $this->sendResponse($response);
    }

    /**
     * Prevents multiple app instances
     * 
     * @throws \Exception
     * @return void No value is returned
     */
    public function __clone()
    {
        throw new \Exception('Cannot have multiple App instances');
    }

    /**
     * Prevents multiple app instances
     * 
     * @throws \Exception
     * @return void No value is returned
     */
    public function __wakeup()
    {
        throw new \Exception('Cannot have multiple App instances');
    }

}
