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
            throw new \InvalidArgumentException('The id argument must be of type string');
        }
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('The dir argument must be of type string');
        }
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \InvalidArgumentException('The dir specified does not exist');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('The options argument must be of type array');
        }
        self::$data[strtolower($id)] = [$dir, $options];
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
            throw new \InvalidArgumentException('The id argument must be of type string');
        }
        return isset(self::$data[strtolower($id)]);
    }

    /**
     * Returns information about the addon
     * @param string $id The addon id
     * @return string Associative array containing the keys 'id', 'dir' and 'options' for the addon specified
     * @throws \InvalidArgumentException
     */
    static function get($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('The id argument must be of type string');
        }
        if (isset(self::$data[$id])) {
            return [
                'id' => $id,
                'dir' => self::$data[$id][0],
                'options' => self::$data[$id][1]
            ];
        }
        throw new \InvalidArgumentException('Addon not found');
    }

    /**
     * Returns an array containing the data of all registered addons
     * @return array An array containing the data of all registered addons
     */
    static function getList()
    {
        $result = [];
        foreach (self::$data as $id => $data) {
            $result[] = [
                'id' => $id,
                'dir' => $data[0],
                'options' => $data[1]
            ];
        }
        return $result;
    }

}
