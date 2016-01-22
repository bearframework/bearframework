<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

class Addons
{

    /**
     *
     * @var array 
     */
    private $options = [];

    /**
     * 
     * @param string $id
     * @param array $options
     * @throws \InvalidArgumentException
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
     * 
     * @param string $id
     * @throws \InvalidArgumentException
     */
    private function load($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        $__id = $id;
        unset($id);
        if (strlen($app->config->addonsDir) === 0) {
            throw new Exception('');
        }
        $__indexFile = realpath($app->config->addonsDir . $__id . '/index.php');
        if ($__indexFile !== false) {
            $context = new \App\AddonContext($app->config->addonsDir . $__id . '/');
            include_once $__indexFile;
        }
    }

    /**
     * 
     * @param string $id
     * @return array
     * @throws \InvalidArgumentException
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

    /**
     * 
     * @param string $id
     * @return App\Addons\Manifest
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    function getManifest($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        $addonsDir = $app->config->addonsDir;
        if (strlen($addonsDir) === 0) {
            throw new Exception('');
        }
        // todo cache
        $filename = $addonsDir . $id . '/manifest.json';
        if (is_file($filename)) {
            $addonsData = \App\Addons\Manifest\Parser::parse(file_get_contents($filename));
            if ($addonsData->id === $id) {
                return $addonsData;
            } else {
                throw new \Exception('Invalid addon id (' . $id . ')');
            }
        } else {
            throw new \Exception('Addon manifest file cannot be found (' . $id . ')');
        }
    }

    /**
     * 
     * @param array $options
     * @param array $values
     * @return boolean
     * @throws \InvalidArgumentException
     */
    function validateOptions($options, $values)
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($values)) {
            throw new \InvalidArgumentException('');
        }
        foreach ($options as $optionData) {
            $id = $optionData['id'];
            $validations = isset($optionData['validations']) ? $optionData['validations'] : [];
            if (empty($validations)) {
                continue;
            }
            foreach ($validations as $validationData) {
                if (isset($validationData[0])) {
                    if ($validationData[0] === 'required') { // todo indexa da go nqma???
                        if (!isset($values[$id]) || strlen($values[$id]) === 0) {
                            return false;
                        }
                    }
                    // todo other types
                }
            }
        }
        return true;
    }

}
