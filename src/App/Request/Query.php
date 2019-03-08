<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the response query items
 */
class Query
{

    /**
     * @var array 
     */
    private $data = [];

    /**
     *
     */
    private $newQueryItemCache = null;

    /**
     * Constructs a new query item and returns it.
     * 
     * @var string|null $name The name of the query item.
     * @var string|null $value The value of the query item.
     * @return \BearFramework\App\Request\QueryItem Returns a new query item.
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Request\QueryItem
    {
        if ($this->newQueryItemCache === null) {
            $this->newQueryItemCache = new \BearFramework\App\Request\QueryItem();
        }
        $object = clone($this->newQueryItemCache);
        if ($name !== null) {
            $object->name = $name;
        }
        if ($value !== null) {
            $object->value = $value;
        }
        return $object;
    }

    /**
     * Sets a query item.
     * 
     * @param \BearFramework\App\Request\QueryItem $query item The query item to set.
     * @return self Returns a reference to itself.
     */
    public function set(\BearFramework\App\Request\QueryItem $queryItem): self
    {
        $this->data[$queryItem->name] = $queryItem;
        return $this;
    }

    /**
     * Returns a query item or null if not found.
     * 
     * @param string $name The name of the query item.
     * @return BearFramework\App\Request\QueryItem|null The query item requested of null if not found.
     */
    public function get(string $name): ?\BearFramework\App\Request\QueryItem
    {
        if (isset($this->data[$name])) {
            return clone($this->data[$name]);
        }
        return null;
    }

    /**
     * Returns a query item value or null if not found.
     * 
     * @param string $name The name of the query item.
     * @return string|null The query item value requested of null if not found.
     */
    public function getValue(string $name): ?string
    {
        if (isset($this->data[$name])) {
            return $this->data[$name]->value;
        }
        return null;
    }

    /**
     * Returns information whether a query item with the name specified exists.
     * 
     * @param string $name The name of the query item.
     * @return bool TRUE if a query item with the name specified exists, FALSE otherwise.
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Deletes a query item if exists.
     * 
     * @param string $name The name of the query item to delete.
     * @return self Returns a reference to itself.
     */
    public function delete(string $name): self
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all query items.
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Request\QueryItem[] An array containing all query items.
     */
    public function getList()
    {
        $list = new \BearFramework\DataList();
        foreach ($this->data as $queryItem) {
            $list[] = clone($queryItem);
        }
        return $list;
    }

    /**
     * Returns the query items as string.
     * 
     * @return string Returns the query items as string.
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns the query items as string.
     * 
     * @return string Returns the query items as string.
     */
    public function toString()
    {
        $temp = [];
        foreach ($this->data as $queryItem) {
            $temp[$queryItem->name] = $queryItem->value;
        }
        return http_build_query($temp);
    }

}
