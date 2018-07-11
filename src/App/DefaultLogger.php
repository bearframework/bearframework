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
 * The default logger.
 */
class DefaultLogger implements ILogger
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
    function __construct($dir)
    {
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \Exception('The logs directory specified is not valid.');
        }
        $this->dir = $dir;
    }

    /**
     * Appends data to the file specified. The file will be created if not exists.
     * 
     * @param mixed $level The filename of the log file.
     * @param string $message The message that will be logged.
     * @param array $context Additional information to log.
     * @throws \InvalidArgumentException
     * @return void No value is returned.
     */
    public function log(string $level, string $message, array $context = []): void
    {
        $level = trim((string) $level);
        if (strlen($level) === 0) {
            throw new \InvalidArgumentException('The level argument must not be empty');
        }

        $filename = $this->dir . DIRECTORY_SEPARATOR . $level . '-' . date('Y-m-d') . '.log';
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
