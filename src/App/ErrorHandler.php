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
 * The default error handler.
 * @codeCoverageIgnore
 */
class ErrorHandler
{

    /**
     * 
     * @param \Throwable $exception
     * @return void No value is returned.
     */
    static function handleException(\Throwable $exception): void
    {
        self::handleError($exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTrace());
    }

    /**
     * 
     * @param array $errorData
     * @return void No value is returned.
     */
    static function handleFatalError(array $errorData): void
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        $messageParts = explode(' in ' . $errorData['file'] . ':' . $errorData['line'], $errorData['message'], 2);
        self::handleError(trim($messageParts[0]), $errorData['file'], (int) $errorData['line'], isset($messageParts[1]) ? [trim(str_replace('Stack trace:', '', $messageParts[1]))] : []);
    }

    /**
     * 
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $trace
     * @return void No value is returned.
     */
    static function handleError(string $message, string $file, int $line, array $trace): void
    {
        $app = App::get();
        if ($app->config->logErrors) {
            try {
                $data = [];
                $data['file'] = $file;
                $data['line'] = $line;
                $data['trace'] = $trace;
                $data['GET'] = isset($_GET) ? $_GET : null;
                $data['POST'] = isset($_POST) ? $_POST : null;
                $data['SERVER'] = isset($_SERVER) ? $_SERVER : null;
                $app->logger->log('error', $message, $data);
            } catch (\Exception $e) {
                
            }
        }
        if (ob_get_length() > 0) {
            ob_clean();
        }
        if ($app->config->displayErrors) {
            $data = "Error:";
            $data .= "\nMessage: " . $message;
            $data .= "\nFile: " . $file;
            $data .= "\nLine: " . $line;
            $data .= "\nTrace: " . print_r($trace, true);
            $data .= "\nGET: " . print_r(isset($_GET) ? $_GET : null, true);
            $data .= "\nPOST: " . print_r(isset($_POST) ? $_POST : null, true);
            $data .= "\nSERVER: " . print_r(isset($_SERVER) ? $_SERVER : null, true);
            http_response_code(503);
            echo $data;
            exit;
        } else {
            $response = new App\Response\TemporaryUnavailable();
        }
        try {
            $app->respond($response);
        } catch (\Exception $e) {
            http_response_code(503);
            echo 'Temporary Unavailable';
            exit;
        }
    }

}
