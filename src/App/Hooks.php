<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Provides functionality for notifications and data requests
 */
class Hooks
{

    /**
     * Registered hook callbacks
     * @var array 
     */
    private $data = [];

    /**
     * Registers callback for the name specified
     * @param string $name The name
     * @param callable $callback The function to be called where the event happens
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function add($name, $callback)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('');
        }
        if (!isset($this->data[$name])) {
            $this->data[$name] = [];
        }
        $this->data[$name][] = $callback;
    }

    /**
     * Triggers execution of all callbacks hooked to the name specified
     * @param string $name The name
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function execute($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($this->data[$name])) {
            $arguments = func_get_args();
            unset($arguments[0]);
            foreach ($this->data[$name] as $callback) {
                call_user_func_array($callback, $arguments);
            }
        }
    }

}
