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

    static $data = [];

    /**
     * 
     * @param string $name
     * @param string $dir
     */
    static function register($name, $dir)
    {
        self::$data[$name] = $dir;
    }

    /**
     * 
     * @param string $name
     * @return boolean
     */
    static function exists($name)
    {
        return isset(self::$data[$name]);
    }

    /**
     * 
     * @param string $name
     * @return string
     * @throws \Exception
     */
    static function getDir($name)
    {
        if (isset(self::$data[$name])) {
            return self::$data[$name];
        }
        throw new \Exception('');
    }

}
