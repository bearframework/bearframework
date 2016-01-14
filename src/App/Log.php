<?php

/*
 * App
 * 
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
     */
    function write($filename, $data)
    {
        if (!is_string($filename) || strlen($filename) === 0) {
            throw new \InvalidArgumentException('The filename argument must be of type string and must not be empty');
        }
        if (!is_string($data)) {
            throw new \InvalidArgumentException('The data argument must be of type string');
        }

        try {
            $microtime = microtime(true);
            $microtimeParts = explode('.', $microtime);
            $logData = date('H:i:s', $microtime) . ':' . (isset($microtimeParts[1]) ? $microtimeParts[1] : '0') . "\n" . $data . "\n\n";

            $pathParts = pathinfo($filename);
            if (isset($pathParts['dirname']) && !is_dir($pathParts['dirname'])) {
                mkdir($pathParts['dirname'], 0777, true);
            }

            $fileHandler = fopen($filename, 'ab');
            $result = fwrite($fileHandler, $logData);
            fclose($fileHandler);
            return is_int($result);
        } catch (\Exception $e) {
            return false;
        }
    }

}
