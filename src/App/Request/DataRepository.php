<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

use BearFramework\App\Request\DataItem;
use BearFramework\App\Request\DataItemsList;

/**
 * Provides information about the response data items
 */
class DataRepository
{

    /**
     * @var array 
     */
    private $data = [];

    /**
     * Sets a data item
     * 
     * @param \BearFramework\App\Request\DataItem $dataItem The data item to set
     * @return \BearFramework\App\Request\DataRepository
     */
    public function set(\BearFramework\App\Request\DataItem $dataItem): \BearFramework\App\Request\DataRepository
    {
        $this->data[$dataItem->name] = $dataItem;
        return $this;
    }

    /**
     * Returns the data item if set
     * 
     * @param string $name The name of the data item
     * @return BearFramework\App\Request\DataItem|null|mixed The value of the data item if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Request\DataItem
    {
        if (isset($this->data[$name])) {
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
     * @return boolean TRUE if a data item with the name specified exists, FALSE otherwise
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
     * @return \BearFramework\App\Request\DataRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Request\DataRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all data items
     * 
     * @return \BearFramework\App\Request\DataItemsList|\BearFramework\App\Request\DataItem[] An array containing all data items in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new DataItemsList($this->data);
    }
    
}
