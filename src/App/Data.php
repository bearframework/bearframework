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
 * Data storage
 */
class Data
{

    /**
     * The instance of the data storage library
     * 
     * @var type 
     */
    private $instance = null;

    /**
     * Returns the instance of the data storage library
     * 
     * @throws \BearFramework\App\InvalidConfigOptionException
     * @return \ObjectStorage The instance of the data storage library
     */
    private function getInstance()
    {
        if ($this->instance === null) {
            $app = &App::$instance;
            if ($app->config->dataDir === null) {
                throw new App\InvalidConfigOptionException('Config option dataDir is not set');
            }
            $this->instance = new \ObjectStorage($app->config->dataDir);
        }
        return $this->instance;
    }

    /**
     * Retrieves object data for specified key
     * 
     * @param array $parameters Parameters
     * @return array Array containing the requested parts of the object
     */
    public function get($parameters)
    {
        $instance = $this->getInstance();
        return $instance->get($parameters);
    }

    /**
     * Saves data
     * 
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function set($parameters)
    {
        $instance = $this->getInstance();
        return $instance->set($parameters);
    }

    /**
     * Appends data to the object specified. If the object does not exist, it will be created.
     * 
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function append($parameters)
    {
        $instance = $this->getInstance();
        return $instance->append($parameters);
    }

    /**
     * Creates a copy of the object specified
     * 
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function duplicate($parameters)
    {
        $instance = $this->getInstance();
        return $instance->duplicate($parameters);
    }

    /**
     * Changes the key of the object specified
     * 
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function rename($parameters)
    {
        $instance = $this->getInstance();
        return $instance->rename($parameters);
    }

    /**
     * Deletes the object specified and it's metadata
     * 
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function delete($parameters)
    {
        $instance = $this->getInstance();
        return $instance->delete($parameters);
    }

    /**
     * Searches for items
     * 
     * @param array $parameters Parameters
     * @return array List of all items matching che search criteria
     */
    public function search($parameters)
    {
        $instance = $this->getInstance();
        return $instance->search($parameters);
    }

    /**
     * Executes multiple commands
     * 
     * @param array $commands Commands
     * @return array List of commands results
     */
    public function execute($commands)
    {
        $instance = $this->getInstance();
        return $instance->execute($commands);
    }

    /**
     * Marks object as public so it can be accessed as an asset
     * 
     * @param array $parameters Parameters
     * @throws \InvalidArgumentException
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function makePublic($parameters)
    {
        if (!is_array($parameters) || !isset($parameters['key']) || !is_string($parameters['key'])) {
            throw new \InvalidArgumentException('The parameters argument must be of type array and must contain a key named \'key\'');
        }
        $instance = $this->getInstance();
        return $instance->set(
                        [
                            'key' => $parameters['key'],
                            'metadata.internalFrameworkPropertyPublic' => '1'
                        ]
        );
    }

    /**
     * Marks object as private, so it cannot be accessed as an asset
     * 
     * @param array $parameters Parameters
     * @throws \InvalidArgumentException
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function makePrivate($parameters)
    {
        if (!is_array($parameters) || !isset($parameters['key']) || !is_string($parameters['key'])) {
            throw new \InvalidArgumentException('The parameters argument must be of type array and must contain a key named \'key\'');
        }
        $instance = $this->getInstance();
        return $instance->set(
                        [
                            'key' => $parameters['key'],
                            'metadata.internalFrameworkPropertyPublic' => ''
                        ]
        );
    }

    /**
     * Checks if an object is marked as public
     * 
     * @param string $key The object key
     * @throws \InvalidArgumentException
     * @return boolean TRUE if public. FALSE otherwise.
     */
    public function isPublic($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('The key argument must be of type string');
        }
        $instance = $this->getInstance();
        $result = $instance->get(
                [
                    'key' => $key,
                    'result' => ['metadata.internalFrameworkPropertyPublic']
                ]
        );
        return isset($result['metadata.internalFrameworkPropertyPublic']) && $result['metadata.internalFrameworkPropertyPublic'] === '1';
    }

    /**
     * Checks if an key is valid
     * 
     * @param string $key The key to check
     * @return boolean TRUE if valid. FALSE otherwise.
     */
    public function isValidKey($key)
    {
        $instance = $this->getInstance();
        return $instance->isValidKey($key);
    }

    /**
     * Returns the filename of the object key specified
     * 
     * @param string $key The object key
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\InvalidConfigOptionException
     * @return string The filename of the object key specified
     */
    public function getFilename($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('The key argument must be of type string');
        }
        $app = &App::$instance;
        if ($app->config->dataDir === null) {
            throw new App\InvalidConfigOptionException('Config option dataDir is not set');
        }
        if (!$this->isValidKey($key)) {
            throw new \InvalidArgumentException('The key argument is not valid');
        }
        return $app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $key);
    }

    /**
     * Returns the key name of the object filename specified
     * 
     * @param string $filename The filename
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\InvalidConfigOptionException
     * @return The key of the object
     */
    public function getKeyFromFilename($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }
        $app = &App::$instance;
        if ($app->config->dataDir === null) {
            throw new App\InvalidConfigOptionException('Config option dataDir is not set');
        }
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \InvalidArgumentException('The filename specified does not exist');
        }
        if (strpos($filename, $app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR) === 0) {
            return substr($filename, strlen($app->config->dataDir . DIRECTORY_SEPARATOR . 'objects' . DIRECTORY_SEPARATOR));
        } else {
            throw new \InvalidArgumentException('The filename specified is not valid data object');
        }
    }

}
