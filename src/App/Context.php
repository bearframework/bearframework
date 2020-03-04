<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
     * @param \BearFramework\App $app
     * @param string $dir The directory where the current addon or application are located .
     */
    public function __construct(\BearFramework\App $app, string $dir)
    {
        $this
            ->defineProperty('dir', [
                'get' => function () use ($dir) {
                    return $dir;
                },
                'readonly' => true
            ])
            ->defineProperty('assets', [
                'init' => function () use ($app, $dir) {
                    return new App\Context\Assets($app, $dir);
                },
                'readonly' => true
            ])
            ->defineProperty('classes', [
                'init' => function () use ($app, $dir) {
                    return new App\Context\Classes($app, $dir);
                },
                'readonly' => true
            ]);
    }
}
