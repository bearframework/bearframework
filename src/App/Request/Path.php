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
class Path implements \ArrayAccess
{

    /**
     *
     * @var string 
     */
    private $path = '';

    /**
     * 
     * @param string $path
     * @throws \InvalidArgumentException
     */
    public function __construct($path = '')
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('The path argument must be of type string');
        }
        $this->path = $path;
    }

    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->path;
    }

    /**
     * 
     * @param int $offset
     * @param string $value
     * @throws Exception
     */
    function offsetSet($offset, $value)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 
     * @param int $offset
     * @return boolean
     */
    function offsetExists($offset)
    {
        if (!is_int($offset)) {
            throw new \InvalidArgumentException('The offset argument must be of type int');
        }
        $path = trim($this->path, '/');
        if (isset($path{0})) {
            $parts = explode('/', $path);
            return array_key_exists($offset, $parts);
        }
        return false;
    }

    /**
     * 
     * @param int $offset
     * @throws Exception
     */
    function offsetUnset($offset)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * 
     * @param int $offset
     * @return string|null
     */
    function offsetGet($offset)
    {
        if (!is_int($offset)) {
            throw new \InvalidArgumentException('The offset argument must be of type int');
        }
        $path = trim($this->path, '/');
        if (isset($path{0})) {
            $parts = explode('/', $path);
            if (array_key_exists($offset, $parts)) {
                return $parts[$offset];
            }
        }
        return null;
    }

}
