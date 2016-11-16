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
 * @property \BearFramework\App\Config $config The application configuration
 * @property \BearFramework\App\Request $request Provides information about the current request
 * @property \BearFramework\App\Routes $routes Stores the data about the defined routes callbacks
 * @property \BearFramework\App\Logger $logger Provides logging functionlity
 * @property \BearFramework\App\Addons $addons Provides a way to enable addons and manage their options
 * @property \BearFramework\App\Hooks $hooks Provides functionality for notifications and data requests
 * @property \BearFramework\App\Assets $assets Provides utility functions for assets
 * @property \BearFramework\App\Data $data \BearFramework\App\Data
 * @property \BearFramework\App\Cache $cache Data cache
 * @property \BearFramework\App\Classes $classes Provides functionality for autoloading classes
 * @property \BearFramework\App\Urls $urls URLs utilities
 * @property \BearFramework\App\Images $images Images utilities
 */
class App
{

    /**
     * Current Bear Framework version
     * 
     * @var string
     */
    const VERSION = '0.9.3';

    /**
     * Dependency Injection container
     * 
     * @var \BearFramework\App\Container 
     */
    public $container = null;

    /**
     * The instance of the App object. Only one can be created.
     * 
     * @var \BearFramework\App 
     */
    public static $instance = null;

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

        $this->container->set('config', App\Config::class);
        $this->container->set('request', App\Request::class);
        $this->container->set('routes', App\Routes::class);
        $this->container->set('logger', App\Logger::class);
        $this->container->set('addons', App\Addons::class);
        $this->container->set('hooks', App\Hooks::class);
        $this->container->set('assets', App\Assets::class);
        $this->container->set('data', App\Data::class);
        $this->container->set('cache', App\Cache::class);
        $this->container->set('classes', App\Classes::class);
        $this->container->set('urls', App\Urls::class);
        $this->container->set('images', App\Images::class);
    }

    /**
     * Returns the app instance
     * 
     * @return \BearFramework\App
     * @throws \Exception
     */
    static function get()
    {
        if (self::$instance === null) {
            throw new \Exception('App is not constructed yet');
        }
        return self::$instance;
    }

    /**
     * Initializes the environment, the error handlers, includes the app index.php file, the addons index.php files, and registers the assests handler
     */
    public function initialize()
    {
        if (!$this->initialized) {
            $this->initializeEnvironment();
            $this->initializeErrorHandler();
            $this->initializeRequest();

            ob_start();

            if (strlen($this->config->appDir) > 0 && is_file($this->config->appDir . DIRECTORY_SEPARATOR . 'index.php')) {
                include realpath($this->config->appDir . DIRECTORY_SEPARATOR . 'index.php');
            }

            if ($this->config->assetsPathPrefix !== null) {
                $this->routes->add($this->config->assetsPathPrefix . '*', function() {
                    $app = App::$instance;
                    $filename = $app->assets->getFilename((string) $app->request->path);
                    if ($filename === false) {
                        return new App\Response\NotFound();
                    } else {
                        $response = new App\Response\FileReader($filename);
                        if ($app->config->assetsMaxAge !== null) {
                            $response->setMaxAge((int) $app->config->assetsMaxAge);
                        }
                        $mimeType = $app->assets->getMimeType($filename);
                        if ($mimeType !== null) {
                            $response->headers[] = 'Content-Type: ' . $mimeType;
                        }
                        return $response;
                    }
                });
            }
            $this->hooks->execute('initialized');
            ob_end_clean();

            $this->initialized = true;
        }
    }

    /**
     * Sets UTF-8 as the default encoding and updates regular expressions limits
     */
    private function initializeEnvironment()
    {
        // @codeCoverageIgnoreStart
        if ($this->config->updateEnvironment) {
            if (version_compare(phpversion(), '5.6.0', '<')) {
                ini_set('default_charset', 'UTF-8');
                ini_set('mbstring.internal_encoding', 'UTF-8');
            }
            ini_set('mbstring.func_overload', 7);
            ini_set("pcre.backtrack_limit", 100000000);
            ini_set("pcre.recursion_limit", 100000000);
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Initalizes error handling
     */
    private function initializeErrorHandler()
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
     * Initializes the request object
     */
    private function initializeRequest()
    {
        if (isset($_SERVER)) {

            $this->request->method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

            $path = isset($_SERVER['REQUEST_URI']) && strlen($_SERVER['REQUEST_URI']) > 0 ? urldecode($_SERVER['REQUEST_URI']) : '/';
            $position = strpos($path, '?');
            if ($position !== false) {
                $this->request->query = new App\Request\Query(substr($path, $position + 1));
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
            $this->request->path = new App\Request\Path(isset($path{0}) ? $path : '/');
            $this->request->base = $scheme . '://' . $host . ($port !== '' && $port !== '80' ? ':' . $port : '') . $basePath;
        }
    }

    /**
     * Creates a context object for the filename specified
     * 
     * @param string $filename
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return \BearFramework\App\Context The context object
     */
    public function getContext($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \Exception('File does not exists');
        }
        if (is_dir($filename)) {
            $filename .= DIRECTORY_SEPARATOR;
        }
        if (strpos($filename, $this->config->appDir . DIRECTORY_SEPARATOR) === 0) {
            return new App\Context($this->config->appDir);
        }
        $addons = $this->addons->getList();
        foreach ($addons as $data) {
            $addonData = \BearFramework\Addons::get($data['id']);
            if (strpos($filename, $addonData['dir'] . DIRECTORY_SEPARATOR) === 0) {
                return new App\Context($addonData['dir']);
            }
        }
        throw new \Exception('Connot find context');
    }

    /**
     * Call this method to start the application. This method initializes the app and outputs the response.
     * 
     * @return void No value is returned
     */
    public function run()
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
     * @param BearFramework\App\Response $response The response object to prepare
     * @throws \Exception
     * @return void No value is returned
     */
    private function prepareResponse($response)
    {
        $this->hooks->execute('responseCreated', $response);

        // @codeCoverageIgnoreStart
        if (!is_array($response->headers)) {
            throw new \Exception('Invalid response headers. The proerty should be array.');
        }
        foreach ($response->headers as $header) {
            if (!is_string($header)) {
                throw new \Exception('Invalid response header. It should be string.');
            }
        }
        if ($response instanceof App\Response\FileReader) {
            if (!is_file($response->filename) || !is_readable($response->filename)) {
                throw new \Exception('Invalid response filename. The file does not exist or is not readable.');
            }
        } else {
            if (!is_string($response->content)) {
                $response->content = (string) $response->content;
            }
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Sends the response to the client
     * 
     * @param \BearFramework\App\Response $response The response object to be sent
     * @return void No value is returned
     */
    private function sendResponse($response)
    {
        if (!headers_sent()) {
            foreach ($response->headers as $header) {
                header($header);
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
     * @param BearFramework\App\Response $response The response object to output
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function respond($response)
    {
        if ($response instanceof App\Response) {
            $this->prepareResponse($response);
            $this->sendResponse($response);
        } else {
            throw new \InvalidArgumentException('The response argument must be of type BearFramework\App\Response');
        }
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

    /**
     * Returns an object from the dependency injection container
     * 
     * @param string $name The service name
     * @return object Object from the dependency injection container
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($this->container->exists($name)) {
            return $this->container->get($name);
        }
        throw new \Exception('Invalid property name');
    }

    /**
     * Returns information about whether the service is added in the dependency injection container
     * 
     * @param string $name The name of the service
     * @return boolen TRUE if services is added. FALSE otherwise.
     */
    public function __isset($name)
    {
        return $this->container->exists($name);
    }

}
