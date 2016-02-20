<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * Place to register addons that can be enabled for the application
 */
class Addons
{

    /**
     * Registered addons data
     * @var array 
     */
    static $data = [];

    /**
     * Registers an addon
     * @param string $name The addon name
     * @param string $dir The addon location
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    static function register($name, $dir)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        self::$data[$name] = $dir;
    }

    /**
     * Checks whether addon is registered
     * @param string $name The addon name
     * @throws \InvalidArgumentException
     * @return boolean TRUE if addon is registered. FALSE otherwise.
     */
    static function exists($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        return isset(self::$data[$name]);
    }

    /**
     * Returns the addon dir
     * @param string $name The addon name
     * @return string The location of the addon
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    static function getDir($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('');
        }
        if (isset(self::$data[$name])) {
            return self::$data[$name];
        }
        throw new \Exception('');
    }

}
