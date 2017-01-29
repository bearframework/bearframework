<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 *  Provides a way to enable addons and manage their options.
 */
class AddonsRepository
{

    /**
     *
     * @var array 
     */
    private $data = [];

    /**
     * Enables an addon and saves the provided options.
     * 
     * @param string $id The id of the addon.
     * @param array $options The options of the addon.
     * @throws \InvalidArgumentException
     * @return bool TRUE if successfully loaded. FALSE otherwise.
     */
    public function add(string $id, array $options = []): bool
    {
        if (isset($this->data[$id])) {
            return false;
        }
        $registeredAddon = \BearFramework\Addons::get($id);
        if ($registeredAddon === null) {
            throw new \InvalidArgumentException('The addon ' . $id . ' is not registered!');
        }
        $registeredAddonOptions = $registeredAddon->options;
        if (isset($registeredAddonOptions['require']) && is_array($registeredAddonOptions['require'])) {
            foreach ($registeredAddonOptions['require'] as $requiredAddonID) {
                if (is_string($requiredAddonID)) {
                    $this->add($requiredAddonID);
                }
            }
        }

        $this->data[$id] = new \BearFramework\App\Addon($id, $registeredAddon->dir, $options);

        $indexFilename = $registeredAddon->dir . DIRECTORY_SEPARATOR . 'index.php';
        if (is_file($indexFilename)) {
            ob_start();
            try {
                (static function($__filename) {
                    include_once $__filename;
                })($indexFilename);
                ob_end_clean();
            } catch (\Exception $e) {
                ob_end_clean();
                throw $e;
            }
            return true;
        } else {
            throw new \InvalidArgumentException('Invalid addon (the index file is missing)');
        }
    }

    /**
     * Returns the enabled addon or null if not found.
     * 
     * @param string $id The id of the addon.
     * @return BearFramework\App\Addon|null The enabled addon or null if not found.
     */
    public function get(string $id): ?\BearFramework\App\Addon
    {
        if (isset($this->data[$id])) {
            return clone($this->data[$id]);
        }
        return null;
    }

    /**
     * Returns information whether an addon with the id specified is enabled.
     * 
     * @param string $id  The id of the addon.
     * @return bool TRUE if an addon with the name specified is enabled, FALSE otherwise.
     */
    public function exists(string $id): bool
    {
        return isset($this->data[$id]);
    }

    /**
     * Returns a list of all enabled addons.
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Addon[] An array containing all enabled addons.
     */
    public function getList()
    {
        return new \BearFramework\DataList(function() {
            $list = [];
            foreach ($this->data as $addon) {
                $list[] = clone($addon);
            }
            return $list;
        });
    }

}
