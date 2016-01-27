<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides functionality for autoloading classes
 */
class Classes
{

    /**
     * Registered classes
     * @var array 
     */
    private $data = [];

    /**
     * Registers a class for autoloading
     * @param string $class The class name
     * @param string $filename The filename that contains the class
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    function add($class, $filename)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $this->data[$class] = $filename;
    }

    /**
     * Loads a class if registered
     * @param string $class
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    function load($class)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        if (isset($this->data[$class])) {
            $app->load($this->data[$class]);
        }
    }

}
