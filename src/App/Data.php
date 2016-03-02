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
     * @var type 
     */
    private $instance = null;

    /**
     * Returns the instance of the data storage library
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
     * @param array $parameters Parameters
     * @throws \InvalidArgumentException
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function makePublic($parameters)
    {
        if (!is_array($parameters) || !isset($parameters['key']) || !is_string($parameters['key'])) {
            throw new \InvalidArgumentException('');
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
     * @param array $parameters Parameters
     * @throws \InvalidArgumentException
     * @return boolean TRUE on success. FALSE otherwise.
     */
    public function makePrivate($parameters)
    {
        if (!is_array($parameters) || !isset($parameters['key']) || !is_string($parameters['key'])) {
            throw new \InvalidArgumentException('');
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
     * @param string $key The object key
     * @throws \InvalidArgumentException
     * @return boolean TRUE if public. FALSE otherwise.
     */
    public function isPublic($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
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
     * Returns the filename of the object key specified
     * @param string $key The object key
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\InvalidConfigOptionException
     * @return The filename of the object key specified
     */
    public function getFilename($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        $app = &App::$instance;
        if ($app->config->dataDir === null) {
            throw new App\InvalidConfigOptionException('Config option dataDir is not set');
        }
        return $app->config->dataDir . 'objects/' . $key;
    }

}
