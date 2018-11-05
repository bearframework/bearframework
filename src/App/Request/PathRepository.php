<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request path.
 */
class PathRepository
{

    /**
     * @var string 
     */
    private $path = '';

    /**
     * 
     * @param string $path The request path.
     */
    public function __construct(string $path = '')
    {
        $this->path = $path;
    }

    /**
     * Returns the full path.
     * 
     * @return string Returns the full path.
     */
    public function __toString()
    {
        return $this->path;
    }

    /**
     * Sets a new path.
     * 
     * @param string $path The new path.
     * @param bool $encode Whether to encode the path.
     * @return self Returns a reference to itself.
     */
    public function set(string $path, bool $encode = true): self
    {
        $this->path = $encode ? implode('/', array_map('urlencode', explode('/', $path))) : $path;
        return $this;
    }

    /**
     * Returns the full path.
     * 
     * @return string Returns the full path.
     */
    public function get(): string
    {
        return $this->path;
    }

    /**
     * Returns the value of the path segment for the index specified or null if not found.
     * 
     * @param int $index the index of the path segment.
     * @param bool $decode whether to apply urldecode.
     * @return string|null The value of the path segment for the index specified or null if not found.
     */
    public function getSegment($index, $decode = true): ?string
    {
        $path = trim($this->path, '/');
        if (isset($path{0})) {
            $parts = explode('/', $path);
            if (array_key_exists($index, $parts)) {
                return $decode ? urldecode($parts[$index]) : $parts[$index];
            }
        }
        return null;
    }

}
