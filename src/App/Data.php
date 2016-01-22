<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

class Data
{

    /**
     *
     * @var type 
     */
    private $instance = null;

    /**
     * 
     * @return \ObjectStorage
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
     * @param array $parameters
     * @return array
     */
    function get($parameters)
    {
        $instance = $this->getInstance();
        return $instance->get($parameters);
    }

    /**
     * 
     * @param array $parameters
     * @return boolean
     */
    function set($parameters)
    {
        $instance = $this->getInstance();
        return $instance->set($parameters);
    }

    /**
     * 
     * @param array $parameters
     * @return boolean
     */
    function append($parameters)
    {
        $instance = $this->getInstance();
        return $instance->append($parameters);
    }

    /**
     * 
     * @param array $parameters
     * @return boolean
     */
    function duplicate($parameters)
    {
        $instance = $this->getInstance();
        return $instance->duplicate($parameters);
    }

    /**
     * 
     * @param array $parameters
     * @return boolean
     */
    function rename($parameters)
    {
        $instance = $this->getInstance();
        return $instance->rename($parameters);
    }

    /**
     * 
     * @param array $parameters
     * @return boolean
     */
    function delete($parameters)
    {
        $instance = $this->getInstance();
        return $instance->delete($parameters);
    }

    /**
     * 
     * @param array $parameters
     * @return array
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
