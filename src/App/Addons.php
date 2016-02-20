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
    private $data = [];

    /**
     * Enables an addon and saves the provided options
     * @param string $name The name of the addon
     * @param array $options The options of the addon
     * @throws \InvalidArgumentException
     * @throws \BearFramework\App\InvalidConfigOptionException
     * @return void No value is returned
     */
    public function add($name, $options = [])
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $pathname = \BearFramework\Addons::getDir($name);
        $pathname = rtrim($pathname, '/\\') . '/';
        $this->data[$name] = [
            'pathname' => $pathname,
            'options' => $options
        ];

        $__indexFile = realpath($pathname . 'index.php');
        if ($__indexFile !== false) {
            $app = &App::$instance; // Needed for the index file
            $context = new App\AddonContext($pathname);
            $context->options = $options;
            unset($name); // Hide this variable from the file scope
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
        $result = [];
        foreach ($this->data as $name => $data) {
            $result[] = array_merge(['name' => $name], $data);
        }
        return $result;
    }

}
