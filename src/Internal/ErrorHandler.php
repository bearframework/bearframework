<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\Internal;

use BearFramework\App;

/**
 * The default error handler.
 * @internal
 */
class ErrorHandler
{

    /**
     * 
     * @param \BearFramework\App $app
     * @param \Throwable $exception
     * @param array $options
     * @return void No value is returned.
     */
    static function handleException(\BearFramework\App $app, \Throwable $exception, array $options): void
    {
        $errors = [];
        while ($exception instanceof \Exception || $exception instanceof \Error) {
            $message = 'Exception: ' . $exception->getMessage() . ' in ' . $exception->getFile() . ':' . $exception->getLine();
            $trace = $exception->getTrace();
            $errors[] = ['message' => $message, 'trace' => $trace];
            $exception = $exception->getPrevious();
        }
        $errors = array_reverse($errors);
        self::handleErrors($app, $errors, $options);
    }

    /**
     * 
     * @param \BearFramework\App $app
     * @param array $errorData
     * @param array $options
     * @return void No value is returned.
     */
    static function handleFatalError(\BearFramework\App $app, array $errorData, array $options): void
    {
        $messageParts = explode(' in ' . $errorData['file'] . ':' . $errorData['line'], $errorData['message'], 2);
        $message = 'Fatal error: ' . trim($messageParts[0]) . ' in ' . $errorData['file'] . ':' . (int) $errorData['line'];
        $trace = isset($messageParts[1]) ? [trim(str_replace('Stack trace:', '', $messageParts[1]))] : [];
        self::handleErrors($app, [['message' => $message, 'trace' => $trace]], $options);
    }

    /**
     * 
     * @param \BearFramework\App $app
     * @param array $errors
     * @param array $options
     * @return void No value is returned.
     */
    static private function handleErrors(\BearFramework\App $app, array $errors, $options): void
    {
        $level = ob_get_level();
        for ($i = 0; $i < $level; $i++) {
            ob_end_clean();
        }

        $logErrors = isset($options['logErrors']) && (bool) $options['logErrors'] === true;
        $displayErrors = isset($options['displayErrors']) && (bool) $options['displayErrors'] === true;

        if ($logErrors || $displayErrors) {
            if ($logErrors) {
                $logKey = uniqid();
            }
            for ($i = 0; $i < 3; $i++) {
                if (!$logErrors && $i !== 2) {
                    continue;
                }
                if (!$displayErrors && $i === 2) {
                    continue;
                }

                $isSimpleLog = $i === 0 || $i === 2;
                $log = '';
                $addContent = function (string $title, string $data) use (&$log) {
                    if (isset($log[0])) {
                        $log .= "\n\n";
                    }
                    $log .= $title . ':' . (isset($data[0]) ? "\n" . trim($data) : '');
                };
                if ($logErrors && $isSimpleLog) {
                    $addContent('Log key', $logKey);
                }

                $errorsCount = sizeof($errors);
                foreach ($errors as $j => $error) {
                    $message = isset($error['message']) ? $error['message'] : '';
                    $trace = isset($error['trace']) ? $error['trace'] : [];

                    $simpleTrace = [];
                    foreach ($trace as $traceRow) {
                        $simpleTrace[] = (isset($traceRow['file']) ? $traceRow['file'] . ':' . (isset($traceRow['line']) ? $traceRow['line'] : '') : '...');
                    }
                    if ($errorsCount > 1) {
                        $addContent('Error ' . ($j + 1) . ' of ' . $errorsCount, '');
                    }
                    $addContent('Message', $message);
                    $addContent('Trace', implode("\n", $simpleTrace));
                }

                $addContent('Request', $app->request->method . ' ' . $app->request->base . $app->request->path);
                if (!$isSimpleLog) {
                    $addContent(
                        'PHP variables',
                        print_r(
                            [
                                'GET' => $_GET,
                                'POST' => $_POST,
                                'SERVER' => $_SERVER
                            ],
                            true
                        )
                    );
                }

                if ($i !== 2) {
                    if ($logErrors) {
                        try {
                            if ($isSimpleLog) {
                                $app->logs->log('error', $log);
                            } else {
                                $app->logs->log('error-' . $logKey, $log);
                            }
                        } catch (\Exception $e) {
                        }
                    }
                } else {
                    if ($displayErrors) {
                        http_response_code(503);
                        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
                        header("Pragma: no-cache");
                        echo (($errorsCount > 1) ? $errorsCount . ' errors occurred:' : 'Error occurred:') . "\n\n";
                        echo $log;
                        exit;
                    }
                }
            }
        }

        try {
            $app->send(new App\Response\TemporaryUnavailable());
        } catch (\Exception $e) {
            http_response_code(503);
            header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
            header("Pragma: no-cache");
            echo 'Temporarily Unavailable';
        }
        exit;
    }
}
