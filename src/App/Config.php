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

    use \IvoPetkov\DataObjectTrait;

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

        $this->defineProperty('appDir', [
            'set' => function($value) {
                if ($value === null) {
                    return $value;
                }
                $value = realpath($value);
                if ($value === false) {
                    throw new \InvalidArgumentException('The value in the appDir option is not a real directory');
                }
                return $value;
            }
        ]);

        $this->defineProperty('dataDir', [
            'set' => function($value) {
                if ($value === null) {
                    return $value;
                }
                $value = realpath($value);
                if ($value === false) {
                    throw new \InvalidArgumentException('The value in the dataDir option is not a real directory');
                }
                return $value;
            }
        ]);

        $this->defineProperty('logsDir', [
            'set' => function($value) {
                if ($value === null) {
                    return $value;
                }
                $value = realpath($value);
                if ($value === false) {
                    throw new \InvalidArgumentException('The value in the logsDir option is not a real directory');
                }
                return $value;
            }
        ]);

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
        $data = array_merge($defaultOptions, $options);
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
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
            $includeFile = static function($__filename) {
                return include $__filename;
            };
            $data = $includeFile($filename);
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
