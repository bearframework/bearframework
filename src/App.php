<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

/**
 * The is the class used to instantiate and configure you application.
 */
class App
{

    /**
     * Current Bear Framework version
     * @var string
     */
    const VERSION = '0.6.2';

    /**
     * The application configuration
     * @var App\Config 
     */
    public $config = null;

    /**
     * Provides information about the current request
     * @var App\Request
     */
    public $request = null;

    /**
     * Stores the data about the defined routes callbacks
     * @var App\Routes 
     */
    public $routes = null;

    /**
     * Provides logging functionlity
     * @var App\Log 
     */
    public $log = null;

    /**
     * HTML Server Components utilities
     * @var App\Components
     */
    public $components = null;

    /**
     * Provides a way to enable addons and manage their options
     * @var App\Addons
     */
    public $addons = null;

    /**
     * Provides functionality for notifications and data requests
     * @var App\Hooks
     */
    public $hooks = null;

    /**
     * Provides utility functions for assets
     * @var App\Assets
     */
    public $assets = null;

    /**
     * Data storage
     * @var App\Data
     */
    public $data = null;

    /**
     * Data cache
     * @var App\Cache 
     */
    public $cache = null;

    /**
     * Provides functionality for autoloading classes
     * @var App\Classes 
     */
    public $classes = [];

    /**
     * The instance of the App object. Only one can be created.
     * @var App 
     */
    public static $instance = null;

    /**
     * The constructor
     * @param array $config
     */
    function __construct($config = [])
    {

        if (self::$instance === null) {
            if (version_compare(phpversion(), '5.6.0', '<')) {
                ini_set('default_charset', 'UTF-8');
                ini_set('mbstring.internal_encoding', 'UTF-8');
            }
            ini_set('mbstring.func_overload', 7);
            ini_set("pcre.backtrack_limit", 100000000);
            ini_set("pcre.recursion_limit", 100000000);
            self::$instance = &$this;
        } else {
            throw new \Exception('App already constructed');
        }

        $this->config = new \App\Config($config);

        if ($this->config->handleErrors) {
            // @codeCoverageIgnoreStart
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            $handleError = function($message, $file, $line, $trace) {
                $data = "Error:";
                $data .= "\nMessage: " . $message;
                $data .= "\nFile: " . $file;
                $data .= "\nLine: " . $line;
                $data .= "\nTrace: " . $trace;
                $data .= "\nGET: " . print_r($_GET, true);
                $data .= "\nPOST: " . print_r($_POST, true);
                $data .= "\nSERVER: " . print_r($_SERVER, true);
                if ($this->config->logErrors && strlen($this->config->logsDir) > 0 && strlen($this->config->errorLogFilename) > 0) {
                    try {
                        $this->log->write($this->config->errorLogFilename, $data);
                    } catch (\Exception $e) {
                        
                    }
                }
                if ($this->config->displayErrors) {
                    ob_clean();
                    $response = new \App\Response\TemporaryUnavailable($data);
                    $response->disableHooks = true;
                } else {
                    $response = new \App\Response\TemporaryUnavailable();
                }
                $this->respond($response);
            };
            set_exception_handler(function($exception) use($handleError) {
                $handleError($exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTraceAsString());
            });
            register_shutdown_function(function() use($handleError) {
                $errorData = error_get_last();
                if (is_array($errorData)) {
                    $messageParts = explode(' in ' . $errorData['file'] . ':' . $errorData['line'], $errorData['message'], 2);
                    $handleError(trim($messageParts[0]), $errorData['file'], $errorData['line'], isset($messageParts[1]) ? trim(str_replace('Stack trace:', '', $messageParts[1])) : '');
                }
            });
            set_error_handler(function($errorNumber, $errorMessage, $errorFile, $errorLine) {
                throw new \ErrorException($errorMessage, 0, $errorNumber, $errorFile, $errorLine);
            }, E_ALL | E_STRICT);
            // @codeCoverageIgnoreEnd
        }
        spl_autoload_register(function ($class) {
            $this->classes->load($class);
        });

        $this->request = new \App\Request();

        if (isset($_SERVER)) {

            if (isset($_SERVER['REQUEST_METHOD'])) {
                $this->request->method = $_SERVER['REQUEST_METHOD'];
            }

            $path = isset($_SERVER['REQUEST_URI']) && strlen($_SERVER['REQUEST_URI']) > 0 ? urldecode($_SERVER['REQUEST_URI']) : '/';
            $position = strpos($path, '?');
            if ($position !== false) {
                $this->request->query = new \App\Request\Query(substr($path, $position + 1));
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
                    if ($dirName === DIRECTORY_SEPARATOR) {
                        $basePath = '';
                        $path = $path;
                    } else {
                        $basePath = $dirName;
                        $path = substr($path, strlen($dirName));
                    }
                }
            }

            $scheme = (isset($_SERVER['REQUEST_SCHEME']) && $_SERVER['REQUEST_SCHEME'] === 'https') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || (isset($_SERVER['HTTP_X_FORWARDED_PROTOCOL']) && $_SERVER['HTTP_X_FORWARDED_PROTOCOL'] === 'https') || (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';
            $host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'unknownhost';
            $this->request->path = new \App\Request\Path(isset($path{0}) ? $path : '/');
            $this->request->base = $scheme . '://' . $host . $basePath;
        }
        $this->routes = new \App\Routes();
        $this->log = new \App\Log();
        $this->components = new \App\Components();
        $this->addons = new \App\Addons();
        $this->hooks = new \App\Hooks();
        $this->assets = new \App\Assets();
        $this->data = new \App\Data();
        $this->cache = new \App\Cache();
        $this->classes = new \App\Classes();
    }

    /**
     * Loads a file
     * @param string $filename The filename to be loaded
     * @throws \InvalidArgumentException
     * @return boolean TRUE if file loaded successfully. Otherwise returns FALSE.
     */
    function load($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $filename = realpath($filename);
        if ($filename !== false) {
            include_once $filename;
            return true;
        }
        return false;
    }

    /**
     * Constructs a url for the path specified
     * @param string $path The path
     * @throws \InvalidArgumentException
     * @return string Absolute URL containing the base URL plus the path given
     */
    function getUrl($path = '/')
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('');
        }
        return $this->request->base . $path;
    }

    /**
     * Call this method to start the application. This method outputs the response.
     * @return void No value is returned
     */
    function run()
    {
        $app = &self::$instance; // needed for the app index file

        if (strlen($this->config->appDir) > 0 && is_file($this->config->appDir . 'index.php')) {
            $context = new \App\AppContext($this->config->appDir);
            include realpath($this->config->appDir . 'index.php');
        }

        if ($this->config->assetsPathPrefix !== null) {
            $this->routes->add($this->config->assetsPathPrefix . '*', function() use ($app) {
                $filename = $app->assets->getFilename((string) $app->request->path);
                if ($filename === false) {
                    return new \App\Response\NotFound();
                } else {
                    $response = new \App\Response\FileReader($filename);
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

        ob_start();
        $response = $this->routes->getResponse($this->request);
        ob_end_clean();
        if (!($response instanceof \App\Response)) {
            $response = new \App\Response\NotFound("Not Found");
        }
        $this->respond($response);
    }

    /**
     * Outputs a response
     * @param App\Response $response The response object to output
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return void No value is returned
     */
    function respond($response)
    {
        if ($response instanceof \App\Response) {
            if (!isset($response->disableHooks) || $response->disableHooks === false) {
                $response->content = $this->components->process($response->content);
                $this->hooks->execute('responseCreated', $response);
                $response->content = $this->components->process($response->content);
            }
            if (!headers_sent()) {
                foreach ($response->headers as $header) {
                    header($header);
                }
            }
            if ($response instanceof \App\Response\FileReader) {
                readfile($response->filename);
            } else {
                echo $response->content;
            }
        } else {
            throw new \InvalidArgumentException('The response argument must be of type \App\Response');
        }
    }

    /**
     * Prevents multiple app instances
     * @throws \Exception
     * @return void No value is returned
     */
    public function __clone()
    {
        throw new \Exception('App object cannot be cloned');
    }

    /**
     * Prevents multiple app instances
     * @throws \Exception
     * @return void No value is returned
     */
    public function __wakeup()
    {
        throw new \Exception('App object cannot be cloned');
    }

}
