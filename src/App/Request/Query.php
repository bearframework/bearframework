<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Request;

/**
 * 
 */
class Query implements \ArrayAccess
{

    /**
     *
     * @var string 
     */
    private $query = '';

    /**
     * 
     * @param string $query
     * @throws \InvalidArgumentException
     */
    public function __construct($query = '')
    {
        if (!is_string($query)) {
            throw new \InvalidArgumentException('The query argument must be of type string');
        }
        $this->query = $query;
    }

    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->query;
    }

    /**
     * 
     * @param mixed $offset
     * @param string $value
     * @throws Exception
     */
    function offsetSet($offset, $value)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 
     * @param mixed $offset
     * @return boolean
     */
    function offsetExists($offset)
    {
        if (!is_string($offset)) {
            throw new \InvalidArgumentException('The offset argument must be of type int');
        }
        $parts = [];
        parse_str($this->query, $parts);
        return array_key_exists($offset, $parts);
    }

    /**
     * 
     * @param mixed $offset
     * @throws Exception
     */
    function offsetUnset($offset)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 
     * @param mixed $offset
     * @return string|null
     */
    function offsetGet($offset)
    {
        if (!is_string($offset)) {
            throw new \InvalidArgumentException('The offset argument must be of type int');
        }
        $parts = [];
        parse_str($this->query, $parts);
        if (array_key_exists($offset, $parts)) {
            return $parts[$offset];
        }
        return null;
    }

}
