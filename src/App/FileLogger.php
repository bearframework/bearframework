<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * A logger that saves the logs in the directory specified.
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
        $dir = rtrim($dir, '/\\');
        if (!is_dir($dir)) {
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
            $microtimeParts = explode('.', (string)microtime(true));
            $logData = date('H:i:s', (int)$microtimeParts[0]) . ':' . str_pad(isset($microtimeParts[1]) ? $microtimeParts[1] : '', 4, '0', STR_PAD_RIGHT) . "\n" . trim($message) . (empty($data) ? '' : "\n" . trim(print_r($data, true))) . "\n\n";
            $fileHandler = @fopen($filename, 'ab');
            if ($fileHandler === false) {
                throw new \Exception('');
            }
            $writeResult = @fwrite($fileHandler, $logData);
            if ($writeResult === false) {
                fclose($fileHandler);
                throw new \Exception('');
            }
            fclose($fileHandler);
        } catch (\Exception $e) {
            throw new \Exception('Cannot write log file (' . $filename . ')');
        }
    }
}
