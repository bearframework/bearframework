<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

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
     * @return \ObjectStorage The instance of the data storage library
     */
    private function getInstance()
    {
        if ($this->instance === null) {
            $app = &\App::$instance;
            if ($app->config->dataDir !== null) {
                $this->instance = new \ObjectStorage($app->config->dataDir);
            } else {
                throw new Exception('');
            }
        }
        return $this->instance;
    }

    /**
     * Retrieves object data for specified key
     * @param array $parameters Parameters
     * @return array Array containing the requested parts of the object
     */
    function get($parameters)
    {
        $instance = $this->getInstance();
        return $instance->get($parameters);
    }

    /**
     * Saves data
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    function set($parameters)
    {
        $instance = $this->getInstance();
        return $instance->set($parameters);
    }

    /**
     * Appends data to the object specified. If the object does not exist it will be created.
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    function append($parameters)
    {
        $instance = $this->getInstance();
        return $instance->append($parameters);
    }

    /**
     * Creates a copy of the object specified
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    function duplicate($parameters)
    {
        $instance = $this->getInstance();
        return $instance->duplicate($parameters);
    }

    /**
     * Changes the key of the object specified
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    function rename($parameters)
    {
        $instance = $this->getInstance();
        return $instance->rename($parameters);
    }

    /**
     * Deletes the object specified and it's metadata
     * @param array $parameters Parameters
     * @return boolean TRUE on success. FALSE otherwise.
     */
    function delete($parameters)
    {
        $instance = $this->getInstance();
        return $instance->delete($parameters);
    }

    /**
     * Searches for items
     * @param array $parameters Parameters
     * @return array List of all items matching che search criteria
     */
    function search($parameters)
    {
        $instance = $this->getInstance();
        return $instance->search($parameters);
    }

    /**
     * 
     * @param string $key
     * @throws \InvalidArgumentException
     */
    function makePublic($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        $instance = $this->getInstance();
        $instance->set(
                [
                    'key' => $key,
                    'metadata.public' => '1'
                ]
        );
    }

    /**
     * 
     * @param string $key
     * @throws \InvalidArgumentException
     */
    function makePrivate($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        $instance = $this->getInstance();
        $instance->set(
                [
                    'key' => $key,
                    'metadata.public' => ''
                ]
        );
    }

    /**
     * 
     * @param string $key
     * @return boolean
     * @throws \InvalidArgumentException
     */
    function isPublic($key)
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        $instance = $this->getInstance();
        $result = $instance->get(
                [
                    'key' => $key,
                    'result' => ['metadata.public']
                ]
        );
        return isset($result['metadata.public']) && $result['metadata.public'] === '1';
    }

    /**
     * 
     * @param string $key
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
     */
    function getUrl($key, $options = [])
    {
        if (!is_string($key)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        return $app->assets->getUrl($app->config->dataDir . 'objects/' . $key, $options);
    }

}
