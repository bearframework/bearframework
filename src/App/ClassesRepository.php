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
class ClassesRepository
{

    /**
     * The registered classes.
     * 
     * @var array 
     */
    private $data = [];

    /**
     *
     * @var ?array 
     */
    private $wildcardCache = null;

    /**
     * 
     */
    public function __construct()
    {
        spl_autoload_register(function (string $class) {
            $this->load($class);
        });
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
        $this->data[$class] = $filename;
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
        return isset($this->data[$class]);
    }

    /**
     * Loads a class if registered.
     * 
     * @param string $class The class name.
     * @return self Returns a reference to itself.
     */
    public function load(string $class): self
    {
        if (isset($this->data[$class])) {
            (static function($__filename) {
                include_once $__filename;
            })($this->data[$class]);
        } else {
            if ($this->wildcardCache === null) {
                $this->wildcardCache = [];
                foreach ($this->data as $_class => $_filename) {
                    if (substr($_class, -2) === '\*') { // Is class in a namespace. Example: Namespace\*
                        $this->wildcardCache[substr($_class, 0, -1)] = $_filename;
                    }
                }
            }
            foreach ($this->wildcardCache as $prefix => $filename) {
                if (strpos($class, $prefix) === 0) {
                    $filename = str_replace('*', substr($class, strlen($prefix)), $filename);
                    (static function($__filename) {
                        include_once $__filename;
                    })($filename);
                    break;
                }
            }
        }
        return $this;
    }

}
