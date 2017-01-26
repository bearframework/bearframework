<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * The place to register addons that can be enabled for the application.
 */
class Addons
{

    /**
     * @var array 
     */
    static private $data = [];

    /**
     *
     */
    private static $newAddonCache = null;

    /**
     * Registers an addon.
     * 
     * @param string $id The id of the addon.
     * @param string $dir The directory where the addon files are located.
     * @param array $options The addon options. Available values:
     *     - require - An array containing the ids of addons that must be added before this one.
     * @return bool TRUE if successfully registered. FALSE otherwise.
     */
    static function register(string $id, string $dir, $options = []): bool
    {
        if(isset(self::$data[$id])){
            return false;
        }
        if (!isset($id{0})) {
            throw new \InvalidArgumentException('The value of the id argument cannot be empty.');
        }
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \InvalidArgumentException('The value of the dir argument is not a valid directory.');
        }
        if (self::$newAddonCache === null) {
            self::$newAddonCache = new \BearFramework\Addon();
        }
        $object = clone(self::$newAddonCache);
        $object->id = $id;
        $object->dir = $dir;
        $object->options = $options;
        self::$data[$id] = $object;
        return true;
    }

    /**
     * Checks whether an addon is registered.
     * 
     * @param string $id The id of the addon.
     * @return bool TRUE if the addon is registered. FALSE otherwise.
     */
    static function exists(string $id): bool
    {
        return isset(self::$data[$id]);
    }

    /**
     * Returns information about the addon requested.
     * 
     * @param string $id The id of the addon.
     * @return \BearFramework\Addon|null Information about the addon requested or null if not found.
     */
    static function get(string $id): ?\BearFramework\Addon
    {
        if (isset(self::$data[$id])) {
            return self::$data[$id];
        }
        return null;
    }

    /**
     * Returns a list of all registered addons.
     * 
     * @return \BearFramework\DataList|\BearFramework\Addon[] A list of all registered addons.
     */
    static function getList()
    {
        return new \BearFramework\DataList(self::$data);
    }

}
