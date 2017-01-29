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
 * The default logger. It saves the logs in the $app->config->logsDir directory.
 */
class DefaultLogger implements ILogger
{

    /**
     * Appends data to the file specified. The file will be created if not exists.
     * 
     * @param mixed $level The filename of the log file.
     * @param string $message The message that will be logged.
     * @param array $context Additional information to log.
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\Config\InvalidOptionException
     * @return void No value is returned.
     */
    public function log(string $level, string $message, array $context = []): void
    {
        $app = App::get();
        $level = trim((string) $level);
        if (strlen($level) === 0) {
            throw new \InvalidArgumentException('The level argument must not be empty');
        }
        if ($app->config->logsDir === null) {
            throw new App\Config\InvalidOptionException('Config option logsDir is not set');
        }

        $filename = $app->config->logsDir . DIRECTORY_SEPARATOR . $level . '-' . date('Y-m-d') . '.log';
        try {
            $microtime = microtime(true);
            $microtimeParts = explode('.', $microtime);
            $logData = date('H:i:s', $microtime) . ':' . (isset($microtimeParts[1]) ? $microtimeParts[1] : '0') . "\n" . trim($message) . (empty($context) ? '' : "\n" . trim(print_r($context, true))) . "\n\n";
            $fileHandler = fopen($filename, 'ab');
            fwrite($fileHandler, $logData);
            fclose($fileHandler);
        } catch (\Exception $e) {
            throw new \Exception('Cannot write log file (' . $filename . ')');
        }
    }

}
