<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * The default logger.
 */
class FileLogger implements ILogger
{

    /**
     *
     * @var string 
     */
    private $dir = null;

    /**
     * 
     * @param string $dir The directory where the logs will be stored.
     */
    public function __construct($dir)
    {
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \Exception('The logs directory specified is not valid.');
        }
        $this->dir = $dir;
    }

    /**
     * Logs the data specified.
     * 
     * @param string $name The name of the log context.
     * @param string $message The message that will be logged.
     * @param array $data Additional information to log.
     * @return void No value is returned.
     */
    public function log(string $name, string $message, array $data = []): void
    {
        $filename = $this->dir . '/' . $name . '-' . date('Y-m-d') . '.log';
        try {
            $microtime = microtime(true);
            $microtimeParts = explode('.', $microtime);
            $logData = date('H:i:s', $microtime) . ':' . (isset($microtimeParts[1]) ? $microtimeParts[1] : '0') . "\n" . trim($message) . (empty($data) ? '' : "\n" . trim(print_r($data, true))) . "\n\n";
            $fileHandler = fopen($filename, 'ab');
            fwrite($fileHandler, $logData);
            fclose($fileHandler);
        } catch (\Exception $e) {
            throw new \Exception('Cannot write log file (' . $filename . ')');
        }
    }

}
