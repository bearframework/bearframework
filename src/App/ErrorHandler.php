<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
     * @param array $backtrace
     * @return void No value is returned.
     */
    static function handleError(string $message, string $file, int $line, array $backtrace): void
    {
        $app = App::get();

        $simpleBacktrace = [];
        foreach ($backtrace as $backtraceRow) {
            $simpleBacktrace[] = (isset($backtraceRow['file']) ? $backtraceRow['file'] : '') . ':' . (isset($backtraceRow['line']) ? $backtraceRow['line'] : '');
        }

        $id = uniqid();

        $data = $message . ' in ' . $file . ':' . $line;
        $data .= "\n\nError ID:\n" . $id;
        $data .= "\n\nRequest:\n" . $app->request->method . ' ' . $app->request->base . $app->request->path;
        $data .= "\n\nSimple backtrace:\n" . implode("\n", $simpleBacktrace);
        $simpleData = $data;
        $data .= "\n\nPHP variables:\n" . print_r([
                    'GET' => $_GET,
                    'POST' => $_POST,
                    'SERVER' => $_SERVER
                        ], true);
        $data .= "\n\nFull backtrace:\n" . print_r($backtrace, true);

        if ($app->config->logErrors) {
            try {
                $app->logger->log('error', $simpleData);
                $app->logger->log('error-' . $id, $data);
            } catch (\Exception $e) {
                
            }
        }
        if (ob_get_length() > 0) {
            ob_clean();
        }
        if ($app->config->displayErrors) {
            http_response_code(503);
            echo "Error occurred:\n\n";
            echo $data;
        } else {
            $response = new App\Response\TemporaryUnavailable();
            try {
                $app->respond($response);
            } catch (\Exception $e) {
                http_response_code(503);
                echo 'Temporary Unavailable';
            }
        }
        exit;
    }

}
