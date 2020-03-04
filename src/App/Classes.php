<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Provides functionality for registering and autoloading classes.
 */
class Classes
{

    /**
     * The registered classes.
     * 
     * @var array 
     */
    private $classes = [];

    /**
     * The registered patterns.
     * 
     * @var array 
     */
    private $patterns = [];

    /**
     * 
     */
    public function __construct()
    {
        spl_autoload_register([$this, 'load']);
    }

    /**
     * Registers a class for autoloading.
     * 
     * @param string $class The class name or class name pattern (format: Namespace\*).
     * @param string $filename The filename that contains the class or path pattern (format: path/to/file/*.php).
     * @return self Returns a reference to itself.
     */
    public function add(string $class, string $filename): self
    {
        if (substr($class, -2) === '\*') { // Is class in a namespace. Example: Namespace\*
            $this->patterns[] = [substr($class, 0, -1), $filename];
        } else {
            $this->classes[$class] = $filename;
        }
        return $this;
    }

    /**
     * Returns information about whether a class is registered for autoloading.
     * 
     * @param string $class The class name.
     * @return boolen TRUE if the class is registered for autoloading. FALSE otherwise.
     */
    public function exists(string $class)
    {
        return $this->getFilename($class) !== null;
    }

    /**
     * Loads a class if registered.
     * 
     * @param string $class The class name.
     * @return self Returns a reference to itself.
     */
    public function load(string $class): self
    {
        $filename = $this->getFilename($class);
        if ($filename !== null) {
            (static function ($__filename) {
                include_once $__filename;
            })($filename);
        }
        return $this;
    }

    /**
     * 
     * @param string $class
     * @return string|nulls
     */
    private function getFilename(string $class): ?string
    {
        if (isset($this->classes[$class])) {
            return $this->classes[$class];
        }
        foreach ($this->patterns as $pattern) {
            list($prefix, $filename) = $pattern;
            if (strpos($class, $prefix) === 0) {
                $filename = str_replace('*', str_replace('\\', '/', substr($class, strlen($prefix))), $filename);
                if (is_file($filename)) {
                    return $filename;
                }
            }
        }
        return null;
    }
}
