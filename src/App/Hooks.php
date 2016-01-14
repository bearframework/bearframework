<?php

namespace App;

class Hooks
{

    /**
     *
     * @var array 
     */
    private $data = [];

    /**
     * 
     * @param string $name
     * @param callable $callback
     */
    function add($name, $callback)
    {
        if (!isset($this->data[$name])) {
            $this->data[$name] = [];
        }
        $this->data[$name][] = $callback;
    }

    /**
     * 
     * @param string $name
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
