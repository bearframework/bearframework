<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 *  Provides a way to enable addons and manage their options
 */
class AddonsRepository
{

    private $data = [];

    /**
     * Enables an addon and saves the provided options
     * 
     * @param string $id The id of the addon
     * @param array $options The options of the addon
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
     * Returns the cookie if set
     * 
     * @param string $id The name of the cookie
     * @return BearFramework\App\Response\Cookie|null|mixed The value of the cookie if set, NULL otherwise
     */
    public function get(string $id): ?\BearFramework\App\Addon
    {
        if (isset($this->data[$id])) {
            return clone($this->data[$id]);
        }
        return null;
    }

    /**
     * Returns information whether a cookie with the name specified exists
     * 
     * @param string $id The name of the cookie
     * @return bool TRUE if a cookie with the name specified exists, FALSE otherwise
     */
    public function exists(string $id): bool
    {
        return isset($this->data[$id]);
    }

    /**
     * Returns a list of all cookies
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Addon[] An array containing all cookies in the following format [['name'=>..., 'value'=>...], ...]
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
