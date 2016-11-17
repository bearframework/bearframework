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
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Registeres a value for the specified name
     * 
     * @param string $name The service name.
     * @param string|object|callable $value The object that will be returned when requested.
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function set($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (!is_string($value) && !is_object($value) && !is_callable($value)) {
            throw new \InvalidArgumentException('The value argument must be of type string, object or callable');
        }
        $this->data[$name] = [$value];
    }

    /**
     * Returns a object and returns it
     * 
     * @param string $name The service name.
     * @return object The object added for the name specified
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function get($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (isset($this->data[$name])) {
            if (isset($this->data[$name][1])) {
                return $this->data[$name][1];
            }
            $result = $this->data[$name][0];
            if (is_string($result)) {
                $result = new $result();
            } elseif (is_callable($result)) {
                ob_start();
                try {
                    $result = call_user_func($result);
                    ob_end_clean();
                } catch (\Exception $e) {
                    ob_end_clean();
                    throw $e;
                }
            } elseif (is_object($result)) {
                return $result;
            }
            $this->data[$name][1] = $result;
            return $result;
        }
        throw new \Exception('');
    }

    /**
     * Returns information about whether the service is added
     * 
     * @param string $name The name of the service
     * @return boolen TRUE if services is added. FALSE otherwise.
     * @throws \InvalidArgumentException
     */
    public function exists($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        return isset($this->data[$name]);
    }

}
