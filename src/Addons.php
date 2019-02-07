<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
     * @return bool TRUE if successfully registered. FALSE otherwise.
     */
    static function register(string $id, string $dir, $options = []): bool
    {
        if (isset(self::$data[$id])) {
            return false;
        }
        if (!isset($id{0})) {
            throw new \InvalidArgumentException('The value of the id argument cannot be empty.');
        }
        $dir = rtrim(\BearFramework\App\Internal\Utilities::normalizePath($dir), '/');
        if (!is_dir($dir)) {
            throw new \InvalidArgumentException('The value of the dir argument is not a valid directory.');
        }
        self::$data[$id] = new \BearFramework\Addon($id, $dir, $options);
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
     * Returns information about the addon specified.
     * 
     * @param string $id The id of the addon.
     * @return \BearFramework\Addon|null Information about the addon requested or null if not found.
     */
    static function get(string $id): ?\BearFramework\Addon
    {
        if (isset(self::$data[$id])) {
            return clone(self::$data[$id]);
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
        $list = new \BearFramework\DataList();
        foreach (self::$data as $addon) {
            $list[] = clone($addon);
        }
        return $list;
    }

}
