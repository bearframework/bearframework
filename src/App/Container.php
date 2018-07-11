<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Services container.
 */
class Container
{

    /**
     * Stores added data.
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Registers a value for the specified name.
     * 
     * @param string $name The service name.
     * @param string|object|callable $value The object that will be returned when requested.
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Container
     */
    public function set(string $name, $value): \BearFramework\App\Container
    {
        if (!is_string($value) && !is_object($value) && !is_callable($value)) {
            throw new \InvalidArgumentException('The value argument must be of type string, object or callable');
        }
        $this->data[$name] = [$value];
        return $this;
    }

    /**
     * Constructs the result and returns it.
     * 
     * @param string $name The service name.
     * @return mixed
     * @throws \Exception
     */
    public function get(string $name)
    {
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
     */
    public function exists(string $name)
    {
        return isset($this->data[$name]);
    }

}
