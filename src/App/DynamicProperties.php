<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Provides functionality for dynamic properties
 */
trait DynamicProperties
{

    /**
     * The object data
     * 
     * @var array 
     */
    private $dynamicData = [];

    /**
     * The registered object properties
     * 
     * @var array 
     */
    private $dynamicProperties = [];

    /**
     * Defines a new property
     * 
     * @param string $name The property name
     * @param array $options The property options ['get'=>callable, 'set'=>callable]
     * @throws \Exception
     */
    public function defineProperty($name, $options)
    {
        if (!is_string($name)) {
            throw new \Exception('The name must be of type string');
        }
        if (!is_array($options)) {
            throw new \Exception('The options must be of type array');
        }
        if (isset($options['init']) && !is_callable($options['init'])) {
            throw new \Exception('The options init attribute must be of type callable');
        }
        if (isset($options['get']) && !is_callable($options['get'])) {
            throw new \Exception('The options get attribute must be of type callable');
        }
        if (isset($options['set']) && !is_callable($options['set'])) {
            throw new \Exception('The options set attribute must be of type callable');
        }
        if (isset($options['unset']) && !is_callable($options['unset'])) {
            throw new \Exception('The options unset attribute must be of type callable');
        }
        $this->dynamicProperties[$name] = [
            isset($options['init']) ? $options['init'] : null,
            isset($options['get']) ? $options['get'] : null,
            isset($options['set']) ? $options['set'] : null,
            isset($options['unset']) ? $options['unset'] : null,
            isset($options['readonly']) && $options['readonly'] === true, // readonly
        ];
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->dynamicProperties[$name]) && isset($this->dynamicProperties[$name][1])) { // get exists
            return call_user_func($this->dynamicProperties[$name][1]);
        }
        if (array_key_exists($name, $this->dynamicData)) {
            return $this->dynamicData[$name];
        } else {
            if (isset($this->dynamicProperties[$name]) && isset($this->dynamicProperties[$name][0])) { // init exists
                $this->dynamicData[$name] = call_user_func($this->dynamicProperties[$name][0]);
                return $this->dynamicData[$name];
            }
            return null;
        }
        throw new \Exception('Undefined property: ' . get_class($this) . '::$' . $name);
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (isset($this->dynamicProperties[$name])) {
            if ($this->dynamicProperties[$name][4]) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->dynamicProperties[$name][2])) { // set exists
                $this->dynamicData[$name] = call_user_func($this->dynamicProperties[$name][2], $value);
                return;
            }
        }
        $this->dynamicData[$name] = $value;
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($this->dynamicProperties[$name]) || array_key_exists($name, $this->dynamicData);
    }

    /**
     * Magic method
     * 
     * @param string $name
     */
    public function __unset($name)
    {
        if (isset($this->dynamicProperties[$name])) {
            if ($this->dynamicProperties[$name][4]) { // readonly
                throw new \Exception('The property ' . get_class($this) . '::$' . $name . ' is readonly');
            }
            if (isset($this->dynamicProperties[$name][3])) { // unset exists
                $this->dynamicData[$name] = call_user_func($this->dynamicProperties[$name][3]);
                return;
            }
        }
        if (array_key_exists($name, $this->dynamicData)) {
            unset($this->dynamicData[$name]);
        }
    }

}
