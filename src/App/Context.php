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
 * @property-read \BearFramework\App\Context\Assets $assets Provides utility functions for assets in the current context dir
 * @property-read \BearFramework\App\Context\Classes $classes Provides functionality for autoloading classes in the current context
 */
class Context
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * The directory where the current addon or application are located
     * 
     * @var string 
     */
    public $dir = '';

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

        $this->defineProperty('assets', [
            'init' => function() use ($dir) {
                return new App\Context\Assets($dir);
            },
            'readonly' => true
        ]);
        $this->defineProperty('classes', [
            'init' => function() use ($dir) {
                return new App\Context\Classes($dir);
            },
            'readonly' => true
        ]);
    }

}
