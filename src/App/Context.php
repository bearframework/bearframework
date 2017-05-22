<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * Provides information about addons and application location and utility functions.
 * 
 * @property-read string $dir The directory where the current addon or application are located.
 * @property-read \BearFramework\App\Context\Assets $assets Provides utility functions for assets in the current context dir.
 * @property-read \BearFramework\App\Context\Classes $classes Provides functionality for autoloading classes in the current context.
 */
class Context
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $dir The directory where the current addon or application are located .
     */
    public function __construct(string $dir)
    {
        $this->defineProperty('dir', [
            'get' => function() use ($dir) {
                return $dir;
            },
            'readonly' => true
        ]);
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
