<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides a way to enable addons and manage their options
 */
class Addons
{

    /**
     * Contains the options for the added addons
     * @var array 
     */
    private $options = [];

    /**
     * Enables an addon and saves the provided options
     * @param string $id The id of the addon
     * @param array $options The options of the addon
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    function add($id, $options = [])
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $this->options[$id] = ['options' => $options];
        $this->load($id);
    }

    /**
     * Loads the addon index file
     * @param string $id The id of the addon
     * @throws \Exception
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    private function load($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        $__id = $id;
        unset($id);
        if ($app->config->addonsDir === null) {
            throw new \Exception('Config option addonsDir not set');
        }
        $__indexFile = realpath($app->config->addonsDir . $__id . '/index.php');
        if ($__indexFile !== false) {
            $context = new \App\AddonContext($app->config->addonsDir . $__id . '/');
            include_once $__indexFile;
        }
    }

    /**
     * Returns the options set for the addon specified
     * @param string $id
     * @throws \InvalidArgumentException
     * @return array The options set for the addon specified
     */
    function getOptions($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($this->options[$id])) {
            return $this->options[$id]['options'];
        }
        return [];
    }

}
