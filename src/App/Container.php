<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Services container
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
            $result = $this->data[$name][0];
            if (is_string($result) || is_callable($result)) {
                if (isset($this->data[$name][1])) {
                    return $this->data[$name][1];
                }
                ob_start();
                try {
                    if (is_string($result)) {
                        $result = new $result();
                    } else { // callable
                        $result = call_user_func($result);
                    }
                    ob_end_clean();
                } catch (\Exception $e) {
                    ob_end_clean();
                    throw $e;
                }
                $this->data[$name][1] = $result;
                return $result;
            }
            if (is_object($result)) {
                $this->data[$name][1] = true; // needed by the used() method
                return $result;
            }
        }
        throw new \Exception('Service (' . $name . ') not found!');
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

    /**
     * Returns information about whether the service is added and used atleast once
     * 
     * @param string $name The name of the service
     * @return boolen TRUE if services is added and used atleast once. FALSE otherwise.
     * @throws \InvalidArgumentException
     */
    public function used($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        return isset($this->data[$name], $this->data[$name][1]);
    }

}
