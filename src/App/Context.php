<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides information about addons and application location and utility functions
 */
class Context
{

    /**
     * The directory where the current addon or application are located
     * @var string 
     */
    public $dir = '';

    /**
     * Provides utility functions for assets in the current context dir
     * @var \App\Context\Assets 
     */
    public $assets = null;

    /**
     * The constructor
     * @param string $dir The directory where the current addon or application are located 
     * @throws \InvalidArgumentException
     */
    function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        $this->dir = $dir;
        $this->assets = new \App\Context\Assets($dir);
    }

    /**
     * Loads a file from the current context dir
     * @param string $filename The filename to be loaded
     * @throws \InvalidArgumentException
     * @return boolean
     */
    function load($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        return $app->load($this->dir . $filename);
    }

    /**
     * Registers a class for autoloading in the current context dir
     * @param string $class The class name
     * @param string $filename The filename that contains the class
     * @throws \InvalidArgumentException
     * @return void No value is returned No value is returned
     */
    function registerClass($class, $filename)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        $app->classes[$class] = $this->dir . $filename;
    }

}
