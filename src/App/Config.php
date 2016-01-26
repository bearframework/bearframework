<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * The application configuration
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
     * Stores the configuration options
     * @var array 
     */
    private $options = [];

    /**
     * The constructor
     * @param array $options Configuration options
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
            'appDir' => null,
            'addonsDir' => null,
            'dataDir' => null,
            'logsDir' => null,
            'handleErrors' => true,
            'displayErrors' => false,
            'logErrors' => false,
            'errorLogFilename' => 'errors/' . date('Y-m-d') . '.log',
            'assetsPathPrefix' => '/assets/',
            'assetsMaxAge' => 0,
            'autoUpdateFramework' => false,
            'autoUpdateAddons' => false
        ];
        $this->options = array_merge($defaultOptions, $options);
    }

    /**
     * Returns the value of the configuration option specified
     * @param string $name The name of the configuration option
     * @throws \InvalidArgumentException
     * @return mixed The value of the configuration option. If missing will return null.
     */
    function __get($name)
    {
        if (array_key_exists($name, $this->options)) {
            return $this->options[$name];
        }
        return null;
    }

    /**
     * Sets the value of the configuration option specified
     * @param string $name The name of the configuration option
     * @param mixed $value The value of the configuration option
     * @throws \Exception
     * @return void No value is returned
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
     * Checks if the configuration option specified is set
     * @param string $name The name of the configuration option
     * @throws \InvalidArgumentException
     * @return boolean TRUE if the configuration option is set. FALSE otherwise.
     */
    function __isset($name)
    {
        return array_key_exists($name, $this->options);
    }

}
