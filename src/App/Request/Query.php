<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request query string
 */
class Query implements \ArrayAccess
{

    /**
     * The request query string
     * @var string 
     */
    private $query = '';

    /**
     * The constructor
     * @param string $query The request query string
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function __construct($query = '')
    {
        if (!is_string($query)) {
            throw new \InvalidArgumentException('The query argument must be of type string');
        }
        $this->query = $query;
    }

    /**
     * Returns the full query string
     * @return string The full query string
     */
    public function __toString()
    {
        return $this->query;
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
     * Checks if data for the current name specified exists
     * @param mixed $offset The name of the data
     * @return boolean TRUE if the data exists. FALSE otherwise.
     */
    public function offsetExists($offset)
    {
        if (!is_string($offset)) {
            throw new \InvalidArgumentException('The offset argument must be of type int');
        }
        $parts = [];
        parse_str($this->query, $parts);
        return array_key_exists($offset, $parts);
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
     * Returns the data for the name specified
     * @param mixed $offset The name of the data
     * @return string|null The data for the name specified
     */
    public function offsetGet($offset)
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
