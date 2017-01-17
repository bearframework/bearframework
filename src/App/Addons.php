<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Provides a way to enable addons and manage their options
 */
class Addons
{

    /**
     * Added addons
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Enables an addon and saves the provided options
     * 
     * @param string $id The id of the addon
     * @param array $options The options of the addon
     * @throws \InvalidArgumentException
     * @return boolean TRUE if successfully loaded. FALSE otherwise.
     */
    public function add($id, $options = [])
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('The id argument must be of type string');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('The options argument must be of type array');
        }
        $id = strtolower($id);
        if (isset($this->data[$id])) {
            return false;
        }
        $addonData = \BearFramework\Addons::get($id);
        $definitionOptions = $addonData['options'];
        if (isset($definitionOptions['require']) && is_array($definitionOptions['require'])) {
            foreach ($definitionOptions['require'] as $requiredAddonName) {
                if (is_string($requiredAddonName)) {
                    $this->add($requiredAddonName);
                }
            }
        }

        $this->data[$id] = [$options];

        $indexFilename = realpath($addonData['dir'] . DIRECTORY_SEPARATOR . 'index.php');
        if ($indexFilename !== false) {
            ob_start();
            try {
                $includeFile = static function($__filename) {
                    include_once $__filename;
                };
                $includeFile($indexFilename);
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
     * Checks whether addon is added
     * 
     * @param string $id The addon id
     * @throws \InvalidArgumentException
     * @return boolean TRUE if addon is added. FALSE otherwise.
     */
    public function exists($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('The id argument must be of type string');
        }
        return isset($this->data[strtolower($id)]);
    }

    /**
     * Returns information about the addon
     * 
     * @param string $id The addon id
     * @return string Associative array containing the keys 'id' and 'options' for the addon specified
     * @throws \InvalidArgumentException
     */
    public function get($id)
    {
        if (!is_string($id)) {
            throw new \InvalidArgumentException('The id argument must be of type string');
        }
        if (isset($this->data[$id])) {
            return [
                'id' => $id,
                'options' => $this->data[$id][0]
            ];
        }
        throw new \InvalidArgumentException('Addon not found');
    }

    /**
     * Returns list of the added addons
     * 
     * @return BearFramework\App\AddonsList|BearFramework\App\AddonsListObject[] List of the added addons
     */
    public function getList()
    {
        $list = new AddonsList();
        foreach ($this->data as $id => $data) {
            $list[] = new AddonsListObject([
                'id' => $id,
                'options' => new \IvoPetkov\DataObject($data[0])
            ]);
        }
        return $list;
    }

}

/**
 * 
 */
class AddonsList extends \IvoPetkov\DataList
{
    
}

/**
 * @property string $id
 * @property \IvoPetkov\DataObject $options
 */
class AddonsListObject extends \IvoPetkov\DataObject
{
    
}
