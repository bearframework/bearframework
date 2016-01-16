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
     */
    function add($id, $options = [])
    {
        $this->options[$id] = ['options' => $options];
        $this->load($id);
    }

    /**
     * 
     * @param string $id
     */
    function load($id)
    {
        global $app;
        $__id = $id;
        unset($id);
        if (strlen($app->config->addonsDir) === 0) {
            throw new Exception('');
        }
        $__indexFile = realpath($app->config->addonsDir . $__id . '/index.php');
        if ($__indexFile !== false) {
            $context = new \App\Context();
            $context->dir = $app->config->addonsDir . $__id . '/';
            include_once $__indexFile;
        }
    }

    /**
     * 
     * @param string $id
     * @return array
     */
    function getOptions($id)
    {
        if (isset($this->options[$id])) {
            return $this->options[$id]['options'];
        }
        return [];
    }

    /**
     * 
     * @param string $addonID
     * @return type
     * @throws \Exception
     */
    function getManifest($addonID)
    {
        global $app;
        $addonsDir = $app->config->addonsDir;
        if (strlen($addonsDir) === 0) {
            throw new Exception('');
        }
        // todo cache
        $filename = $addonsDir . $addonID . '/manifest.json';
        if (is_file($filename)) {
            $addonsData = \App\Addons\Manifest\Parser::parse(file_get_contents($filename));
            if ($addonsData->id === $addonID) {
                return $addonsData;
            } else {
                throw new \Exception('Invalid addon id (' . $addonID . ')');
            }
        } else {
            throw new \Exception('Addon manifest file cannot be found (' . $addonID . ')');
        }
    }

    /**
     * 
     * @param array $options
     * @param array $values
     */
    function validateOptions($options, $values)
    {
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
