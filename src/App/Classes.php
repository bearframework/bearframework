<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

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
     * The constructor
     */
    public function __construct()
    {
        spl_autoload_register(function ($class) {
            $this->load($class);
        });
    }

    /**
     * Registers a class for autoloading
     * @param string $class The class name
     * @param string $filename The filename that contains the class
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function add($class, $filename)
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
    public function load($class)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($this->data[$class])) {
            include_once $this->data[$class];
        }
    }

}
