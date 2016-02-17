<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request path
 */
class Path implements \ArrayAccess
{

    /**
     * The request path
     * @var string 
     */
    private $path = '';

    /**
     * The constructor
     * @param string $path The request path
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function __construct($path = '')
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('The path argument must be of type string');
        }
        $this->path = $path;
    }

    /**
     * Returns the full path
     * @return string The full path
     */
    public function __toString()
    {
        return $this->path;
    }

    /**
     * Not implemented
     * @param int $offset
     * @param string $value
     * @throws \Exception
     * @return void No value is returned
     */
    public function offsetSet($offset, $value)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Checks if a part part for the current index specified exists
     * @param int $offset The index of the path part
     * @return boolean TRUE if the path part exists. FALSE otherwise.
     */
    public function offsetExists($offset)
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
     * Not implemented
     * @param int $offset
     * @throws \Exception
     * @return void No value is returned
     */
    public function offsetUnset($offset)
    {
        throw new \Exception('Not implemented');
    }

    /**
     * Returns the path part for the index specified
     * @param int $offset the index of the part part
     * @return string|null The path part at the index specified
     */
    public function offsetGet($offset)
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
