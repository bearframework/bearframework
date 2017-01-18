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
     * Registers an addon.
     * 
     * @param string $id The id of the addon.
     * @param string $dir The directory where the addon files are located.
     * @param array $options The addon options. Available values:
     *     - require - An array containing the ids of addons that must be added before this one.
     * @return void No value is returned
     */
    static function register(string $id, string $dir, $options = []): void
    {
        self::$data[$id] = new \BearFramework\Addon($id, $dir, $options);
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
     * @return \BearFramework\AddonsList|\BearFramework\Addon[] A list of all registered addons.
     */
    static function getList()
    {
        return new \BearFramework\AddonsList(self::$data);
    }

}
