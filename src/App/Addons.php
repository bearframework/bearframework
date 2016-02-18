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
 * Provides a way to enable addons and manage their options
 */
class Addons
{

    /**
     * Added addons
     * @var array 
     */
    private $addons = [];

    /**
     * Enables an addon and saves the provided options
     * @param string $pathname The directory where the addon index.php file is located
     * @param array $options The options of the addon
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\InvalidConfigOptionException
     * @return void No value is returned
     */
    public function add($pathname, $options = [])
    {
        if (!is_string($pathname)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $pathname = rtrim($pathname, '/\\') . '/';
        $this->addons[] = [
            'pathname' => $pathname,
            'options' => $options
        ];

        $__indexFile = realpath($pathname . 'index.php');
        if ($__indexFile !== false) {
            $app = &App::$instance; // Needed for the index file
            $context = new App\AddonContext($pathname);
            $context->options = $options;
            unset($pathname); // Hide this variable from the file scope
            unset($options); // Hide this variable from the file scope
            include_once $__indexFile;
        }
    }

    /**
     * Returns list of the added addons
     * @return array List of the added addons
     */
    public function getList()
    {
        return $this->addons;
    }

}
