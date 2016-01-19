<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * 
 */
class Log
{

    /**
     * 
     * @param string $filename
     * @param string $data
     * @return boolean
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    function write($filename, $data)
    {
        $app = &\App::$instance;
        if (!is_string($filename) || strlen($filename) === 0) {
            throw new \InvalidArgumentException('The filename argument must be of type string and must not be empty');
        }
        if (!is_string($data)) {
            throw new \InvalidArgumentException('The data argument must be of type string');
        }
        if (strlen($app->config->logsDir) === 0) {
            throw new \Exception('logsDir config variable is not set');
        }

        try {
            $microtime = microtime(true);
            $microtimeParts = explode('.', $microtime);
            $logData = date('H:i:s', $microtime) . ':' . (isset($microtimeParts[1]) ? $microtimeParts[1] : '0') . "\n" . $data . "\n\n";
            \App\Utilities\File::makeDir($app->config->logsDir . $filename);
            $fileHandler = fopen($app->config->logsDir . $filename, 'ab');
            $result = fwrite($fileHandler, $logData);
            fclose($fileHandler);
            return is_int($result);
        } catch (\Exception $e) {
            return false;
        }
    }

}
