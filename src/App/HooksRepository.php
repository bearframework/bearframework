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
     * @param mixed $arg1 An argument that will be passes to the callbacks
     * @param mixed $arg2 An argument that will be passes to the callbacks
     * @param mixed $arg3 An argument that will be passes to the callbacks
     * @param mixed $arg4 An argument that will be passes to the callbacks
     * @param mixed $arg5 An argument that will be passes to the callbacks
     * @param mixed $arg6 An argument that will be passes to the callbacks
     * @param mixed $arg7 An argument that will be passes to the callbacks
     * @param mixed $arg8 An argument that will be passes to the callbacks
     * @param mixed $arg9 An argument that will be passes to the callbacks
     * @param mixed $arg10 An argument that will be passes to the callbacks
     * @return \BearFramework\App\HooksRepository A reference to itself.
     */
    public function execute(string $name, &$arg1 = null, &$arg2 = null, &$arg3 = null, &$arg4 = null, &$arg5 = null, &$arg6 = null, &$arg7 = null, &$arg8 = null, &$arg9 = null, &$arg10 = null): \BearFramework\App\HooksRepository
    {
        if (isset($this->data[$name])) {
            ob_start();
            try {
                $argumentsCount = func_num_args() - 1;
                foreach ($this->data[$name] as $callback) {
                    switch ($argumentsCount) {
                        case 0:
                            $callback();
                            break;
                        case 1:
                            $callback($arg1);
                            break;
                        case 2:
                            $callback($arg1, $arg2);
                            break;
                        case 3:
                            $callback($arg1, $arg2, $arg3);
                            break;
                        case 4:
                            $callback($arg1, $arg2, $arg3, $arg4);
                            break;
                        case 5:
                            $callback($arg1, $arg2, $arg3, $arg4, $arg5);
                            break;
                        case 6:
                            $callback($arg1, $arg2, $arg3, $arg4, $arg5, $arg5);
                            break;
                        case 7:
                            $callback($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7);
                            break;
                        case 8:
                            $callback($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8);
                            break;
                        case 9:
                            $callback($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8, $arg9);
                            break;
                        case 10:
                            $callback($arg1, $arg2, $arg3, $arg4, $arg5, $arg6, $arg7, $arg8, $arg9, $arg10);
                            break;
                        default:
                            throw new \Exception('The hooks system does not support more than 10 arguments');
                    }
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
