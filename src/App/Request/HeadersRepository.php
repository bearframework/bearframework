<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
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
    private static $newHeaderCache = null;

    /**
     * 
     * @return \BearFramework\App\Request\Header
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Request\Header
    {
        if (self::$newHeaderCache === null) {
            self::$newHeaderCache = new \BearFramework\App\Request\Header();
        }
        $object = clone(self::$newHeaderCache);
        if ($name !== null) {
            $object->name = $name;
        }
        if ($value !== null) {
            $object->value = $value;
        }
        return $object;
    }

    /**
     * Sets a header
     * 
     * @param \BearFramework\App\Request\Header $header The header to set
     * @return \BearFramework\App\Request\HeadersRepository
     */
    public function set(\BearFramework\App\Request\Header $header): \BearFramework\App\Request\HeadersRepository
    {
        $this->data[$header->name] = $header;
        return $this;
    }

    /**
     * Returns the header if set
     * 
     * @param string $name The name of the header
     * @return BearFramework\App\Request\Header|null|mixed The value of the header if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Request\Header
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * Returns the value of the header if set
     * 
     * @param string $name The name of the header
     * @return string|null|mixed The value of the header if set, NULL otherwise
     */
    public function getValue(string $name): ?string
    {
        if (isset($this->data[$name])) {
            return $this->data[$name]->value;
        }
        return null;
    }

    /**
     * Returns information whether a header with the name specified exists
     * 
     * @param string $name The name of the header
     * @return bool TRUE if a header with the name specified exists, FALSE otherwise
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Deletes a header if exists
     * 
     * @param string $name The name of the header to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\HeadersRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Request\HeadersRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all headers
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Request\Header[] An array containing all headers in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new \BearFramework\DataList($this->data);
    }

}
