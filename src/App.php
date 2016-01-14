<?php

/*
 * App
 * 
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

class App
{

    /**
     * Current version
     * @var string
     */
    const VERSION = '0.5.0';

    /**
     *
     * @var \App\Config 
     */
    public $config = null;

    /**
     *
     * @var \App\Request
     */
    public $request = null;

    /**
     *
     * @var \App\Routes 
     */
    public $routes = null;

    /**
     *
     * @var \App\Log 
     */
    public $log = null;

    /**
     *
     * @var \App\Components
     */
    public $components = null;

    /**
     *
     * @var \App\Addons
     */
    public $addons = null;

    /**
     *
     * @var \App\Hooks
     */
    public $hooks = null;

    /**
     *
     * @var \App\Assets
     */
    public $assets = null;

    /**
     *
     * @var \App\Data
     */
    public $data = null;

    /**
     *
     * @var \App\Cache 
     */
    public $cache = null;

    /**
     *
     * @var boolean 
     */
    private static $initialized = false;

    /**
     * 
     * @param array $config
     */
    function __construct($config = [])
    {

        $this->config = new \App\Config($config);

        if (self::$initialized === false) {
            if (version_compare(phpversion(), '5.6.0', '<')) {
                ini_set('default_charset', 'UTF-8');
                ini_set('mbstring.internal_encoding', 'UTF-8');
            }
            ini_set('mbstring.func_overload', 7);
            ini_set("pcre.backtrack_limit", 100000000);
            ini_set("pcre.recursion_limit", 100000000);
            self::$initialized = true;
        }

        if ($this->config->handleErrors) {
            error_reporting(E_ALL | E_STRICT);
            ini_set('display_errors', 0);
            ini_set('display_startup_errors', 0);
            set_exception_handler([$this, 'handleException']);
            register_shutdown_function([$this, 'checkForErrors']);
            set_error_handler(function($errorNumber, $errorMessage, $errorFile, $errorLine) {
                throw new \ErrorException($errorMessage, 0, $errorNumber, $errorFile, $errorLine);
            }, E_ALL | E_STRICT);
        }

        $this->request = new \App\Request();

        if (isset($_SERVER)) {

            if (isset($_SERVER['REQUEST_METHOD'])) {
                $this->request->method = $_SERVER['REQUEST_METHOD'];
            }
            if (isset($_SERVER['REQUEST_SCHEME'])) {
                $this->request->scheme = $_SERVER['REQUEST_SCHEME'] === 'https' || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ? 'https' : 'http';
            }
            if (isset($_SERVER['SERVER_NAME'])) {
                $this->request->host = $_SERVER['SERVER_NAME'];
            }

            $path = isset($_SERVER['REQUEST_URI']) && strlen($_SERVER['REQUEST_URI']) > 0 ? urldecode($_SERVER['REQUEST_URI']) : '/';
            $position = strpos($path, '?');
            if ($position !== false) {
                $this->request->query = new \App\Request\Query(substr($path, $position + 1));
                $path = substr($path, 0, $position);
            }
            unset($position);

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
                    unset($dirName);
                    unset($pathInfo);
                }
                unset($scriptName);
            }

            if ($this->request->scheme !== '' && $this->request->host !== '') {
                $this->request->path = new \App\Request\Path(isset($path{0}) ? $path : '/');
                $this->request->base = $this->request->scheme . '://' . $this->request->host . $basePath;
            }
            unset($path);
            unset($basePath);
        }
        $this->routes = new \App\Routes();
        $this->log = new \App\Log();
        $this->components = new \App\Components();
        $this->addons = new \App\Addons();
        $this->hooks = new \App\Hooks();
        $this->assets = new \App\Assets();
        $this->data = new \App\Data($this->config->dataDir);
        $this->cache = new \App\Cache();
    }

    /**
     * 
     */
    function run()
    {
        $app = &$this; // needed for the app index file
        $context = new \App\Context();
        $context->dir = $this->config->appDir;
        if (is_file($this->config->appDir . 'index.php')) {
            include realpath($this->config->appDir . 'index.php');
        } else {
            $response = new \App\Response\TemporaryUnavailable('Add your application code in ' . $this->config->appDir . 'index.php');
            $this->terminate($response);
        }

        if ($this->config->assetsPathPrefix !== null) {
            $this->routes->add($this->config->assetsPathPrefix . '*', function() use ($app) {
                $filename = $app->assets->getFilename($app->request->path);
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
        $this->hooks->execute('requestStarted');

        ob_start();
        $response = $this->routes->getResponse($this->request);
        ob_end_clean();
        if (!($response instanceof \App\Response)) {
            $response = new \App\Response\NotFound("Not Found");
        }
        $this->respond($response);
    }

    /**
     * 
     * @param \App\Response $response
     * @throws \InvalidArgumentException
     */
    function respond($response)
    {
        if ($response instanceof \App\Response) {
            if ($response instanceof \App\Response\HTML) {
                $response->content = $this->components->process($response->content);
            }
            $this->hooks->execute('responseCreated', $response);
            $this->sendResponse($response);
        } else {
            throw new \InvalidArgumentException('The response argument must be of type \App\Response');
        }
    }

    /**
     * This is the default response handler. It renders the headers and the content
     * @param \App\Response $response
     */
    function sendResponse($response)
    {
        if ($response instanceof \App\Response) {
            if ($response instanceof \App\Response\HTML) {
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
     * 
     */
    function handleException($exception)
    {
        $this->handleError($exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTraceAsString());
    }

    /**
     * 
     */
    function checkForErrors()
    {
        $this->handleLastError(error_get_last());
    }

    /**
     * 
     * @param array $errorData
     */
    protected function handleLastError($errorData)
    {
        if (is_array($errorData)) {
            $messageParts = explode(' in ' . $errorData['file'] . ':' . $errorData['line'], $errorData['message'], 2);
            $this->handleError(trim($messageParts[0]), $errorData['file'], $errorData['line'], isset($messageParts[1]) ? trim(str_replace('Stack trace:', '', $messageParts[1])) : '');
        }
    }

    /**
     * 
     * @param string $message
     * @param string $file
     * @param int $line
     * @param string $trace
     */
    protected function handleError($message, $file, $line, $trace)
    {
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
                $this->log->write($this->config->logsDir . $this->config->errorLogFilename, $data);
            } catch (\Exception $e) {
                
            }
        }
        if ($this->config->displayErrors) {
            $response = new \App\Response\TemporaryUnavailable($data);
        } else {
            $response = new \App\Response\TemporaryUnavailable();
        }
        $this->respond($response);
    }

}
