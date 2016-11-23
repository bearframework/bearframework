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
 * Provides information about addons and application location and utility functions
 * 
 * @property \BearFramework\App\Context\Assets $assets Provides utility functions for assets in the current context dir
 * @property \BearFramework\App\Context\Classes $classes Provides functionality for autoloading classes in the current context
 */
class Context
{

    /**
     * The directory where the current addon or application are located
     * 
     * @var string 
     */
    public $dir = '';

    /**
     * Services container
     * 
     * @var \BearFramework\App\Container 
     */
    public $container = null;

    /**
     * The constructor
     * 
     * @param string $dir The directory where the current addon or application are located 
     * @throws \InvalidArgumentException
     */
    public function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('The dir argument must be of type string');
        }
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \InvalidArgumentException('The dir specified does not exist');
        }
        $this->dir = $dir;

        $this->container = new App\Container();

        $this->container->set('assets', function() use($dir) {
            return new App\Context\Assets($dir);
        });
        $this->container->set('classes', function() use($dir) {
            return new App\Context\Classes($dir);
        });
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($this->container->exists($name)) {
            return $this->container->get($name);
        }
        throw new \Exception('The property requested (' . $name . ') cannot be found in the services container');
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return $this->container->exists($name);
    }

}
