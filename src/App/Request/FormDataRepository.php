<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

use BearFramework\App\Request\FormDataItem;
use BearFramework\App\Request\FormDataItemsList;

/**
 * Provides information about the response data items
 */
class FormDataRepository
{

    /**
     * @var array 
     */
    private $data = [];
    
    /**
     *
     */
    private static $newFormDataItemCache = null;

    /**
     * 
     * @return \BearFramework\App\Request\FormDataItem
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Request\FormDataItem
    {
        if (self::$newFormDataItemCache === null) {
            self::$newFormDataItemCache = new \BearFramework\App\Request\FormDataItem();
        }
        $object = clone(self::$newFormDataItemCache);
        if ($name !== null) {
            $object->name = $name;
        }
        if ($value !== null) {
            $object->value = $value;
        }
        return $object;
    }

    /**
     * Sets a data item
     * 
     * @param \BearFramework\App\Request\FormDataItem $dataItem The data item to set
     * @return \BearFramework\App\Request\FormDataRepository
     */
    public function set(\BearFramework\App\Request\FormDataItem $dataItem): \BearFramework\App\Request\FormDataRepository
    {
        $this->data[$dataItem->name] = $dataItem;
        return $this;
    }

    /**
     * Returns the data item if set
     * 
     * @param string $name The name of the data item
     * @return BearFramework\App\Request\FormDataItem|null The value of the data item if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Request\FormDataItem
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }
    
    /**
     * Returns the file data item if set
     * 
     * @param string $name The name of the file data item
     * @return BearFramework\App\Request\FormDataFileItem|null The value of the data item if set, NULL otherwise
     */
    public function getFile(string $name): ?\BearFramework\App\Request\FormDataFileItem
    {
        if (isset($this->data[$name]) && $this->data[$name] instanceof \BearFramework\App\Request\FormDataFileItem) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * Returns the value of the data item if set
     * 
     * @param string $name The name of the data item
     * @return string|null|mixed The value of the data item if set, NULL otherwise
     */
    public function getValue(string $name): ?string
    {
        if (isset($this->data[$name])) {
            return $this->data[$name]->value;
        }
        return null;
    }

    /**
     * Returns information whether a data item with the name specified exists
     * 
     * @param string $name The name of the data item
     * @return bool TRUE if a data item with the name specified exists, FALSE otherwise
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Deletes a data item if exists
     * 
     * @param string $name The name of the data item to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\FormDataRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Request\FormDataRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all data items
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Request\FormDataItem[] An array containing all data items in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new \BearFramework\DataList($this->data);
    }
    
}
