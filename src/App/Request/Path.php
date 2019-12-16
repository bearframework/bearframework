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
class Path
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
     * @return self Returns a reference to itself.
     */
    public function set(string $path): self
    {
        $this->path = $path;
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
     * @return string|null The value of the path segment for the index specified or null if not found.
     */
    public function getSegment($index): ?string
    {
        $path = trim($this->path, '/');
        if (isset($path[0])) {
            $parts = explode('/', $path);
            if (array_key_exists($index, $parts)) {
                return $parts[$index];
            }
        }
        return null;
    }

    /**
     * Checks if the current path matches the pattern/patterns specified.
     * 
     * @param string|string[] $pattern Path pattern or array of patterns. Can contain "?" (path segment) and "*" (matches everything).
     * @return bool Returns TRUE if the current path matches the pattern provided/
     */
    public function match($pattern): bool
    {
        $requestPath = $this->path;
        $patterns = is_array($pattern) ? $pattern : [$pattern];
        foreach ($patterns as $pattern) {
            if (preg_match('/^' . str_replace(['/', '?', '*'], ['\/', '[^\/]+?', '.+?'], $pattern) . '$/u', $requestPath) === 1) {
                return true;
            }
        }
        return false;
    }

}
