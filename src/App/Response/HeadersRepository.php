<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Provides information about the response headers
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
     * @return \BearFramework\App\Response\Header
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Response\Header
    {
        if (self::$newHeaderCache === null) {
            self::$newHeaderCache = new \BearFramework\App\Response\Header();
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
     * @param \BearFramework\App\Response\Header $header The header to set
     * @return \BearFramework\App\Response\HeadersRepository
     */
    public function set(\BearFramework\App\Response\Header $header): \BearFramework\App\Response\HeadersRepository
    {
        $this->data[$header->name] = $header;
        return $this;
    }

    /**
     * Returns the header if set
     * 
     * @param string $name The name of the header
     * @return BearFramework\App\Response\Header|null|mixed The value of the header if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Response\Header
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
     * @return \BearFramework\App\Response\HeadersRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Response\HeadersRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all headers
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Response\Header[] An array containing all headers in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new \BearFramework\DataList($this->data);
    }

}
