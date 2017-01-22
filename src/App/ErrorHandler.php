<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * 
 */
class ErrorHandler
{

    static function handleException($exception)
    {
        self::handleError($exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTraceAsString());
    }

    static function handleFatalError($errorData)
    {
        if (ob_get_length() > 0) {
            ob_end_clean();
        }
        $messageParts = explode(' in ' . $errorData['file'] . ':' . $errorData['line'], $errorData['message'], 2);
        self::handleError(trim($messageParts[0]), $errorData['file'], $errorData['line'], isset($messageParts[1]) ? trim(str_replace('Stack trace:', '', $messageParts[1])) : '');
    }

    static function handleError($message, $file, $line, $trace)
    {
        $app = App::get();
        if ($app->config->logErrors && strlen($app->config->logsDir) > 0) {
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
        if ($app->config->displayErrors) {
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
