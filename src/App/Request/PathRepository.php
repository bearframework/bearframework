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
class PathRepository
{

    /**
     * The request path
     * 
     * @var string 
     */
    private $path = '';

    /**
     * The constructor
     * 
     * @param string $path The request path
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function __construct(string $path = '')
    {
        $this->path = $path;
    }

    /**
     * Returns the full path
     * 
     * @return string The full path
     */
    public function __toString()
    {
        return $this->path;
    }

    /**
     * Sets a new path
     * 
     * @return string The full path
     */
    public function set(string $path)
    {
        $this->path = $path;
    }

    /**
     * Returns the full path
     * 
     * @return string The full path
     */
    public function get()
    {
        return $this->path;
    }

    /**
     * Returns the path part for the index specified
     * 
     * @param int $offset the index of the part part
     * @return string|null The path part at the index specified
     */
    public function getSegment($index): ?string
    {
        $path = trim($this->path, '/');
        if (isset($path{0})) {
            $parts = explode('/', $path);
            if (array_key_exists($index, $parts)) {
                return $parts[$index];
            }
        }
        return null;
    }

}
