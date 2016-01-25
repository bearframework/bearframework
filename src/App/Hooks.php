<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides functionaly for notifications and data requests
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
     * @return void No value is returned No value is returned
     */
    function add($name, $callback)
    {
        if (!isset($this->data[$name])) {
            $this->data[$name] = [];
        }
        $this->data[$name][] = $callback;
    }

    /**
     * Triggers execution of all callbacks hooked to the name specified
     * @param string $name The name
     * @return void No value is returned No value is returned
     */
    function execute($name)
    {
        if (isset($this->data[$name])) {
            $arguments = func_get_args();
            unset($arguments[0]);
            foreach ($this->data[$name] as $callback) {
                call_user_func_array($callback, $arguments);
            }
        }
    }

}
