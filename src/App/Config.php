<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * 
 * @property-read string $appDir
 * @property-read string $addonsDir
 * @property-read string $dataDir
 * @property-read string $logsDir
 * @property-read boolean $handleErrors
 * @property boolean $displayErrors
 * @property boolean $logErrors
 * @property string $errorLogFilename
 * @property string $assetsPathPrefix
 * @property int $assetsMaxAge
 * @property boolean $autoUpdateFramework
 * @property boolean $autoUpdateAddons
 */
class Config
{

    /**
     *
     * @var array 
     */
    private $options = [];

    /**
     * 
     * @param string $name
     * @return mixed
     * @throws \InvalidArgumentException
     */
    function __get($name)
    {
        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }
        return null;
    }

    /**
     * 
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    function __set($name, $value)
    {
        if ($name === 'handleErrors' || $name === 'appDir' || $name === 'addonsDir' || $name === 'dataDir' || $name === 'logsDir') {
            throw new \Exception('This config option can be modified only through the constructor');
        } else {
            $this->options[$name] = $value;
        }
    }

    /**
     * 
     * @param string $name
     * @return boolean
     * @throws \InvalidArgumentException
     */
    function __isset($name)
    {
        return array_key_exists($name, $this->options);
    }

    /**
     * 
     * @param array $options
     * @throws \InvalidArgumentException
     */
    function __construct($options = [])
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException('This options argument must be of type array');
        }

        if (isset($options['appDir'])) {
            $options['appDir'] = rtrim($options['appDir'], '/\\') . '/';
        }
        if (isset($options['addonsDir'])) {
            $options['addonsDir'] = rtrim($options['addonsDir'], '/\\') . '/';
        }
        if (isset($options['dataDir'])) {
            $options['dataDir'] = rtrim($options['dataDir'], '/\\') . '/';
        }
        if (isset($options['logsDir'])) {
            $options['logsDir'] = rtrim($options['logsDir'], '/\\') . '/';
        }
        $defaultOptions = [
            'handleErrors' => true,
            'displayErrors' => false,
            'logErrors' => false,
            'errorLogFilename' => 'errors/' . date('Y-M-d') . '.log',
            'assetsPathPrefix' => '/assets/',
            'assetsMaxAge' => 0,
            'autoUpdateFramework' => false,
            'autoUpdateAddons' => false
        ];
        $this->options = array_merge($defaultOptions, $options);
    }

    /**
     * 
     * @return array
     */
    function getOptions()
    {
        return $this->options;
    }

}
