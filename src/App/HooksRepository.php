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
class HooksRepository
{

    /**
     * Registered hook callbacks
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Registers callback for the name specified
     * 
     * @param string $name The name
     * @param callable $callback The function to be called where the event happens
     * @param array $options Contains a priority option (default value: 100). Hooks with lower priority will be executed first.
     * @return void No value is returned
     */
    public function add(string $name, callable $callback, array $options = [])
    {
        if (!isset($this->data[$name])) {
            $this->data[$name] = [];
        }
        if (!isset($options['priority'])) {
            // todo validate
            $options['priority'] = 100;
        }
        $this->data[$name][] = [$callback, $options, sizeof($this->data[$name])];
    }

    /**
     * Returns information whether there are callbacks added to the hook specified.
     * 
     * @param string $name The name
     * @return boolean TRUE if there are registered callbacks to the hook specified, FALSE otherwise.
     */
    public function exists(string $name)
    {
        return isset($this->data[$name]);
    }

    /**
     * Triggers execution of all callbacks hooked to the name specified
     * 
     * @param string $name The name
     * @return void No value is returned
     */
    public function execute(string $name)
    {
        if (isset($this->data[$name])) {
            $arguments = func_get_args();
            unset($arguments[0]);
            $callbacks = $this->data[$name];
            if (isset($callbacks[1])) {
                usort($callbacks, function($a, $b) {
                    $difference = (int) $b[1]['priority'] - (int) $a[1]['priority'];
                    if ($difference === 0) {
                        return $a[2] <= $b[2] ? -1 : 1;
                    }
                    return $difference > 0 ? -1 : 1;
                });
            }
            ob_start();
            try {
                foreach ($callbacks as $callback) {
                    call_user_func_array($callback[0], $arguments);
                }
                ob_end_clean();
            } catch (\Exception $e) {
                ob_end_clean();
                throw $e;
            }
        }
    }

}
