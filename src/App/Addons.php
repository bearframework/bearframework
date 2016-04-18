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
     * @param string $id The id of the addon
     * @param array $options The options of the addon
     * @throws \InvalidArgumentException
     * @throws \Exception
     * @return boolean TRUE if successfully loaded. FALSE otherwise.
     */
    public function add($id, $options = [])
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        if (isset($this->data[$id])) {
            return false;
        }
        $definitionOptions = \BearFramework\Addons::getOptions($id);
        if (isset($definitionOptions['require']) && is_array($definitionOptions['require'])) {
            foreach ($definitionOptions['require'] as $requiredAddonName) {
                if (is_string($requiredAddonName)) {
                    $this->add($requiredAddonName);
                }
            }
        }
        $pathname = \BearFramework\Addons::getDir($id);
        $pathname = rtrim($pathname, '/\\') . '/';
        $this->data[$id] = [
            'pathname' => $pathname,
            'options' => $options
        ];

        $__indexFilename = realpath($pathname . 'index.php');
        if ($__indexFilename !== false) {
            $app = &App::$instance; // Needed for the index file
            $context = new App\AddonContext($pathname);
            $context->options = $options;
            unset($id); // Hide this variable from the file scope
            unset($pathname); // Hide this variable from the file scope
            unset($options); // Hide this variable from the file scope
            unset($definitionOptions); // Hide this variable from the file scope
            include_once $__indexFilename;
            return true;
        } else {
            throw new \Exception('Addon index file not found');
        }
    }

    /**
     * Returns list of the added addons
     * @return array List of the added addons
     */
    public function getList()
    {
        $result = [];
        foreach ($this->data as $id => $data) {
            $result[] = array_merge(['id' => $id, 'name' => $id], $data);
        }
        return $result;
    }

}
