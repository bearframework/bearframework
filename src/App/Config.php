<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * The application configuration
 * 
 * @property string $appDir
 * @property string $dataDir
 * @property string $logsDir
 * @property boolean $updateEnvironment
 * @property boolean $handleErrors
 * @property boolean $displayErrors
 * @property boolean $logErrors
 * @property string $assetsPathPrefix
 * @property int $assetsMaxAge
 */
class Config
{

    /**
     * Stores the configuration options
     * 
     * @var array 
     */
    private $data = [];

    /**
     * The constructor
     * 
     * @param array $options Configuration options
     * @throws \InvalidArgumentException
     */
    public function __construct($options = [])
    {
        if (!is_array($options)) {
            throw new \InvalidArgumentException('The options argument must be of type array');
        }
        if (isset($options['appDir'])) {
            $options['appDir'] = realpath($options['appDir']);
            if ($options['appDir'] === false) {
                throw new \InvalidArgumentException('The value in the appDir option is not a real directory');
            }
        }
        if (isset($options['dataDir'])) {
            $options['dataDir'] = realpath($options['dataDir']);
            if ($options['dataDir'] === false) {
                throw new \InvalidArgumentException('The value in the dataDir option is not a real directory');
            }
        }
        if (isset($options['logsDir'])) {
            $options['logsDir'] = realpath($options['logsDir']);
            if ($options['logsDir'] === false) {
                throw new \InvalidArgumentException('The value in the logsDir option is not a real directory');
            }
        }
        $defaultOptions = [
            'appDir' => null,
            'dataDir' => null,
            'logsDir' => null,
            'updateEnvironment' => true,
            'handleErrors' => true,
            'displayErrors' => false,
            'logErrors' => false,
            'assetsPathPrefix' => '/assets/',
            'assetsMaxAge' => 0
        ];
        $this->data = array_merge($defaultOptions, $options);
    }

    /**
     * Returns the value of the configuration option specified
     * 
     * @param string $name The name of the configuration option
     * @throws \InvalidArgumentException
     * @return mixed The value of the configuration option. If missing will return null.
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * Sets the value of the configuration option specified
     * 
     * @param string $name The name of the configuration option
     * @param mixed $value The value of the configuration option
     * @return void No value is returned
     */
    public function __set($name, $value)
    {
        if (($name === 'appDir' || $name === 'dataDir' || $name === 'logsDir') && $value !== null) {
            $value = realpath($value);
            if ($value === false) {
                throw new \InvalidArgumentException('The value in the ' . $name . ' option is not a real directory');
            }
        }
        $this->data[$name] = $value;
    }

    /**
     * Checks if the configuration option specified is set
     * 
     * @param string $name The name of the configuration option
     * @throws \InvalidArgumentException
     * @return boolean TRUE if the configuration option is set. FALSE otherwise.
     */
    public function __isset($name)
    {
        return array_key_exists($name, $this->data);
    }

    /**
     * Loads a config file. The file must return PHP array containing configuration options in the format ['option1'=>'value1', 'option2'=>'value2']
     * 
     * @param string $filename The filename containing the configuration options
     * @throws \InvalidArgumentException
     */
    public function load($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename must be of type string');
        }
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \InvalidArgumentException('The filename specified (' . $filename . ') is not valid');
        }
        ob_start();
        try {
            $data = include $filename;
            ob_end_clean();
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }
        if (is_array($data)) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
        } else {
            throw new \InvalidArgumentException('The configuration data in ' . $filename . ' is not valid');
        }
    }

}
