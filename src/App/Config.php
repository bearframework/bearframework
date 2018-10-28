<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * The application configuration.
 */
class Config
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;

    /**
     * 
     * @param array $options An array of configuration options.
     * @throws \Exception
     */
    public function __construct(array $options = [])
    {
        foreach ($options as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * Loads a configuration file. The file must return PHP array containing configuration options in the format ['option1'=>'value1', 'option2'=>'value2'].
     * 
     * @param string $filename The filename containing the configuration options.
     * @throws \InvalidArgumentException
     */
    public function load(string $filename): \BearFramework\App\Config
    {
        $filename = realpath($filename);
        if ($filename === false) {
            throw new \InvalidArgumentException('The filename specified (' . $filename . ') is not valid!');
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
        throw new \InvalidArgumentException('The configuration data in ' . $filename . ' is not valid!');
    }

}
