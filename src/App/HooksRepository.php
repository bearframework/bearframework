<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Provides functionality for notifications and executing custom code.
 */
class HooksRepository
{

    /**
     * Registered hooks.
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Registers a callback for the name specified.
     * 
     * @param string $name The name that the hook is attached to.
     * @param callable $callback The function to be called when the event occur.
     * @param array $options List of options
     *     - priority - A priority of the callback (default value: 100). Hooks with lower priority will be executed first.
     * @return \BearFramework\App\HooksRepository A reference to itself.
     */
    public function add(string $name, callable $callback, array $options = []): \BearFramework\App\HooksRepository
    {
        if (!isset($this->data[$name])) {
            $this->data[$name] = [];
        }
        if (isset($options['priority'])) {
            if (!is_int($options['priority'])) {
                throw new \Exception('The priority option must be of type int.');
            }
        } else {
            $options['priority'] = 100;
        }
        $this->data[$name][] = [$callback, $options, sizeof($this->data[$name])];
        return $this;
    }

    /**
     * Returns information whether there are callbacks added for the name specified.
     * 
     * @param string $name The name that the hooks are attached to.
     * @return bool TRUE if there are registered callbacks, FALSE otherwise.
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Triggers execution of all callbacks hooked to the name specified
     * 
     * @param string $name The name that the hooks are attached to.
     * @return \BearFramework\App\HooksRepository A reference to itself.
     */
    public function execute(string $name): \BearFramework\App\HooksRepository
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
        return $this;
    }

}
