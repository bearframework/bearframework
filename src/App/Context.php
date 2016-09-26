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
     * Provides utility functions for assets in the current context dir
     * 
     * @var \BearFramework\App\Context\Assets 
     */
    public $assets = null;

    /**
     * Provides functionality for autoloading classes in the current context
     * 
     * @var \BearFramework\App\Context\Classes 
     */
    public $classes = null;

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
        $this->assets = new App\Context\Assets($dir);
        $this->classes = new App\Context\Classes($dir);
    }

}
