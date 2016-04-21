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
    static private $data = [];

    /**
     * Registers an addon
     * @param string $id The addon id
     * @param string $dir The addon location
     * @param array $options Addon options
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    static function register($id, $dir, $options = [])
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        self::$data[$id] = [$dir, $options];
    }

    /**
     * Checks whether addon is registered
     * @param string $id The addon id
     * @throws \InvalidArgumentException
     * @return boolean TRUE if addon is registered. FALSE otherwise.
     */
    static function exists($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        return isset(self::$data[$id]);
    }

    /**
     * Returns the addon dir
     * @param string $id The addon id
     * @return string The location of the addon
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    static function getDir($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (isset(self::$data[$id])) {
            return self::$data[$id][0];
        }
        throw new \Exception('');
    }

    /**
     * Returns the addon options
     * @param string $id The addon id
     * @return string The location of the addon
     * @throws \Exception
     * @throws \InvalidArgumentException
     */
    static function getOptions($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('');
        }
        if (isset(self::$data[$id])) {
            return self::$data[$id][1];
        }
        throw new \Exception('');
    }

    /**
     * Returns an array containing the names of all registered addons
     * @return array The names of all registered addons
     */
    static function getList()
    {
        return array_keys(self::$data);
    }

}
