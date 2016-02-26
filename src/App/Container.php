<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Dependency Injection container
 */
class Container
{

    /**
     * Stores added data
     * @var array 
     */
    private $data = [];

    /**
     * Registeres a value for the specified name
     * @param string $name The service name.
     * @param string|object|callable $value The object that will be returned when requested.
     * @param array $options Array options. Currently there is only one - singleton
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function set($name, $value, $options = [])
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($value) && !is_object($value) && !is_callable($value)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $this->data[$name] = [$value, $options];
    }

    /**
     * Returns a object and returns it
     * @param string $name The service name.
     * @return object The object added for the name specified
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function get($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($this->data[$name])) {
            if (isset($this->data[$name][2])) {
                return $this->data[$name][2];
            }
            $result = $this->data[$name][0];
            $options = array_map('strtoupper', $this->data[$name][1]);
            if (is_string($result)) {
                $result = new $result();
            } elseif (is_callable($result)) {
                $result = call_user_func($result);
            }
            if (array_search('SINGLETON', $options) !== false) {
                $this->data[$name][2] = $result;
            }
            return $result;
        }
        throw new \Exception('');
    }

    /**
     * Returns information about whether the service is added
     * @param string $name The name of the service
     * @return boolen TRUE if services is added. FALSE otherwise.
     * @throws \InvalidArgumentException
     */
    public function has($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        return isset($this->data[$name]);
    }

}
