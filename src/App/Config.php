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
 * @property ?string $appDir
 * @property ?string $dataDir
 * @property ?string $logsDir
 * @property bool $updateEnvironment
 * @property bool $handleErrors
 * @property bool $displayErrors
 * @property bool $logErrors
 * @property ?string $assetsPathPrefix
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
    public function __construct(array $options = [])
    {
        $this->defineProperty('appDir', [
            'type' => '?string',
            'set' => function($value) {
                if ($value === null) {
                    return null;
                }
                $value = realpath($value);
                if ($value === false) {
                    throw new \InvalidArgumentException('The value in the appDir option is not a real directory');
                }
                return $value;
            }
        ]);
        $this->defineProperty('dataDir', [
            'type' => '?string',
            'set' => function($value) {
                if ($value === null) {
                    return null;
                }
                $value = realpath($value);
                if ($value === false) {
                    throw new \InvalidArgumentException('The value in the dataDir option is not a real directory');
                }
                return $value;
            }
        ]);
        $this->defineProperty('logsDir', [
            'type' => '?string',
            'set' => function($value) {
                if ($value === null) {
                    return null;
                }
                $value = realpath($value);
                if ($value === false) {
                    throw new \InvalidArgumentException('The value in the logsDir option is not a real directory');
                }
                return $value;
            }
        ]);
        $this->defineProperty('updateEnvironment', [
            'type' => 'bool',
            'init' => function() {
                return true;
            }
        ]);
        $this->defineProperty('handleErrors', [
            'type' => 'bool',
            'init' => function() {
                return true;
            }
        ]);
        $this->defineProperty('displayErrors', [
            'type' => 'bool',
            'init' => function() {
                return false;
            }
        ]);
        $this->defineProperty('logErrors', [
            'type' => 'bool',
            'init' => function() {
                return false;
            }
        ]);
        $this->defineProperty('assetsPathPrefix', [
            'type' => '?string',
            'init' => function() {
                return '/assets/';
            }
        ]);
        $this->defineProperty('assetsMaxAge', [
            'type' => 'int',
            'init' => function() {
                return 0;
            }
        ]);

        foreach ($options as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * Loads a config file. The file must return PHP array containing configuration options in the format ['option1'=>'value1', 'option2'=>'value2']
     * 
     * @param string $filename The filename containing the configuration options
     * @throws \InvalidArgumentException
     */
    public function load(string $filename): \BearFramework\App\Config
    {
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \InvalidArgumentException('The filename specified (' . $filename . ') is not valid');
        }
        ob_start();
        try {
            $data = (static function($__filename) {
                        return include $__filename;
                    })($filename);
            ob_end_clean();
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }
        if (is_array($data)) {
            foreach ($data as $name => $value) {
                $this->$name = $value;
            }
            return $this;
        }
        throw new \InvalidArgumentException('The configuration data in ' . $filename . ' is not valid');
    }

}
