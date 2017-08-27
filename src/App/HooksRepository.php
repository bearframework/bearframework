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
     * @return \BearFramework\App\HooksRepository A reference to itself.
     */
    public function add(string $name, callable $callback): \BearFramework\App\HooksRepository
    {
        if (!isset($this->data[$name])) {
            $this->data[$name] = [];
        }
        $this->data[$name][] = $callback;
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
            ob_start();
            try {
                foreach ($this->data[$name] as $callback) {
                    call_user_func_array($callback, $arguments);
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
