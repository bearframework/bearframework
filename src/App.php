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

            if (strlen($this->config->appDir) > 0) {
                $indexFilename = realpath($this->config->appDir . DIRECTORY_SEPARATOR . 'index.php');
                if ($indexFilename !== false) {
                    ob_start();
                    try {
                        $includeFile = static function($__filename) {
                            include $__filename;
                        };
                        $includeFile($indexFilename);
                        ob_end_clean();
                    } catch (\Exception $e) {
                        ob_end_clean();
                        throw $e;
                    }
                }
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
                            $response->headers->set('Cache-Control', 'public, max-age=' . (int) $app->config->assetsMaxAge);
                        }
                        $mimeType = $app->assets->getMimeType($filename);
                        if ($mimeType !== null) {
                            $response->headers->set('Content-Type', $mimeType);
                        }
                        $response->headers->set('Content-Length', (string) filesize($filename));
                        return $response;
                    }
                });
            }
            if ($this->container->used('hooks')) { // performance optimization
                $this->hooks->execute('initialized');
            }

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
            $this->request->base = $scheme . '://' . $host . ($port !== '' && $port !== '80' ? ':' . $port : '') . $basePath;
            $this->request->container->set('path', function() use ($path) {
                return new App\Request\Path(isset($path{0}) ? $path : '/');
            });
            $this->request->container->set('query', function() {
                $query = new App\Request\Query();
                foreach ($_GET as $name => $value) {
                    $query->set($name, $value);
                }
                return $query;
            });
            $this->request->container->set('headers', function() {
                $headers = new App\Request\Headers();
                foreach ($_SERVER as $name => $value) {
                    if (substr($name, 0, 5) == 'HTTP_') {
                        $headers->set(str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5))))), $value);
                    }
                }
                return $headers;
            });
            $this->request->container->set('cookies', function() {
                $cookies = new App\Request\Cookies();
                foreach ($_COOKIE as $name => $value) {
                    $cookies->set($name, $value);
                }
                return $cookies;
            });
            $this->request->container->set('data', function() {
                $data = new App\Request\Data();
                foreach ($_POST as $name => $value) {
                    $data->set($name, $value);
                }
                return $data;
            });
            $this->request->container->set('files', function() {
                $files = new App\Request\Files();
                foreach ($_FILES as $name => $value) {
                    if (is_uploaded_file($value['tmp_name'])) {
                        $files->set($name, $value['name'], $value['tmp_name'], $value['size'], $value['type'], $value['error']);
                    }
                }
                return $files;
            });
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
        if ($this->container->used('hooks')) { // performance optimization
            $this->hooks->execute('responseCreated', $response);
        }
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
            if ($response->container->used('headers')) { // performance optimization
                if (count($response->headers) > 0) {
                    $headers = $response->headers->getList();
                    foreach ($headers as $header) {
                        if ($header['name'] === 'Content-Type') {
                            $header['value'] .= '; charset=' . $response->charset;
                        }
                        header($header['name'] . ': ' . $header['value']);
                    }
                }
            }
            if ($response->container->used('cookies')) { // performance optimization
                if (count($response->cookies) > 0) {
                    $baseUrlParts = parse_url($this->request->base);
                    $cookies = $response->cookies->getList();
                    foreach ($cookies as $cookie) {
                        setcookie($cookie['name'], $cookie['value'], $cookie['expire'], $cookie['path'] === null ? (isset($baseUrlParts['path']) ? $baseUrlParts['path'] . '/' : '') : $cookie['path'], $cookie['domain'] === null ? (isset($baseUrlParts['host']) ? $baseUrlParts['host'] : '') : $cookie['domain'], $cookie['secure'] === null ? $this->request->scheme === 'https' : $cookie['secure'], $cookie['httpOnly']);
                    }
                }
            }
        }
        if ($response instanceof App\Response\FileReader) {
            readfile($response->filename);
        } else {
            echo $response->content;
        }
        if ($this->container->used('hooks')) { // performance optimization
            $this->hooks->execute('responseSent', $response);
        }
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
     * Returns an object from the services container
     * 
     * @param string $name The service name
     * @return object Object from the services container
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($this->container->exists($name)) {
            return $this->container->get($name);
        }
        throw new \Exception('The object requested (' . $name . ') cannot be found in the services container');
    }

    /**
     * Returns information about whether the service is added in the services container
     * 
     * @param string $name The name of the service
     * @return boolen TRUE if services is added. FALSE otherwise.
     */
    public function __isset($name)
    {
        return $this->container->exists($name);
    }

}
