<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Logs repository
 */
class LogsRepository
{

    /**
     *
     * @var ?\BearFramework\App\ILogger  
     */
    private $logger = null;

    /**
     * Enables a file logger for directory specified.
     * 
     * @return void No value is returned.
     */
    public function useFileLogger(string $dir): void
    {
        $this->setLogger(new \BearFramework\App\FileLogger($dir));
    }
    
     /**
     * Enables a null logger. The null logger does not log any data and does not throw any errors.
     * 
     * @return void No value is returned.
     */
    public function useNullLogger(): void
    {
        $this->setLogger(new \BearFramework\App\NullLogger());
    }

    /**
     * Sets a new logger.
     * 
     * @param \BearFramework\App\ILogger $logger The logger to use.
     * @return void No value is returned.
     * @throws \Exception
     */
    public function setLogger(\BearFramework\App\ILogger $logger): void
    {
        if ($this->logger !== null) {
            throw new \Exception('A logger is already set!');
        }
        $this->logger = $logger;
    }

    /**
     * Returns the logger.
     * 
     * @return \BearFramework\App\ILogger
     * @throws \Exception
     */
    private function getLogger(): \BearFramework\App\ILogger
    {
        if ($this->logger !== null) {
            return $this->logger;
        }
        throw new \Exception('No logger specified! Use useFileLogger() or setLogger() to specify one.');
    }

    /**
     * Logs the data specified.
     * 
     * @param string $name The name of the log context.
     * @param string $message The message that will be logged.
     * @param array $data Additional information to log.
     * @throws \InvalidArgumentException
     * @return void No value is returned.
     */
    public function log(string $name, string $message, array $data = []): void
    {
        $name = trim((string) $name);
        if (strlen($name) === 0) {
            throw new \InvalidArgumentException('The name argument must not be empty!');
        }

        $logger = $this->getLogger();
        $logger->log($name, $message, $data);
    }

}
