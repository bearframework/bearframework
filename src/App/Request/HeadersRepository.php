<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request headers
 */
class HeadersRepository
{

    /**
     * @var array 
     */
    private $data = [];

    /**
     *
     */
    private $newHeaderCache = null;

    /**
     * Constructs a new header and returns it.
     * 
     * @var string|null $name The name of the header.
     * @var string|null $value The value of the header.
     * @return \BearFramework\App\Request\Header Returns a new header.
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Request\Header
    {
        if ($this->newHeaderCache === null) {
            $this->newHeaderCache = new \BearFramework\App\Request\Header();
        }
        $object = clone($this->newHeaderCache);
        if ($name !== null) {
            $object->name = $name;
        }
        if ($value !== null) {
            $object->value = $value;
        }
        return $object;
    }

    /**
     * Sets a header.
     * 
     * @param \BearFramework\App\Request\Header $header The header to set.
     * @return self Returns a reference to itself.
     */
    public function set(\BearFramework\App\Request\Header $header): self
    {
        $this->data[$header->name] = $header;
        return $this;
    }

    /**
     * Returns a header or null if not found.
     * 
     * @param string $name The name of the header.
     * @return BearFramework\App\Request\Header|null The header requested of null if not found.
     */
    public function get(string $name): ?\BearFramework\App\Request\Header
    {
        if (isset($this->data[$name])) {
            return clone($this->data[$name]);
        }
        return null;
    }

    /**
     * Returns the value of the header or null if not found.
     * 
     * @param string $name The name of the header.
     * @return string|null The value of the header requested of null if not found.
     */
    public function getValue(string $name): ?string
    {
        if (isset($this->data[$name])) {
            return $this->data[$name]->value;
        }
        return null;
    }

    /**
     * Returns information whether a header with the name specified exists.
     * 
     * @param string $name The name of the header.
     * @return bool TRUE if a header with the name specified exists, FALSE otherwise.
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Deletes a header if exists.
     * 
     * @param string $name The name of the header to delete.
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
     * Returns a list of all headers.
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Request\Header[] An array containing all headers.
     */
    public function getList()
    {
        $list = new \BearFramework\DataList();
        foreach ($this->data as $header) {
            $list[] = clone($header);
        }
        return $list;
    }

}
