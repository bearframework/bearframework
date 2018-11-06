<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Context;

use BearFramework\App;

/**
 * Provides functionality for autoloading classes in the current context.
 */
class Classes
{

    /**
     *
     * @var string 
     */
    private $dir = '';

    /**
     *
     * @var \BearFramework\App\ClassesRepository 
     */
    private $appClasses = null;

    /**
     * 
     * @param \BearFramework\App $app
     * @param string $dir The directory where the current addon or application are located.
     */
    public function __construct(\BearFramework\App $app, string $dir)
    {
        $this->dir = str_replace('\\', '/', $dir);
        $this->appClasses = $app->classes;
    }

    /**
     * Registers a class for autoloading in the current context.
     * 
     * @param string $class The class name.
     * @param string $filename The filename that contains the class.
     * @return self Returns a reference to itself.
     */
    public function add(string $class, string $filename): self
    {
        $this->appClasses->add($class, $this->dir . '/' . $filename);
        return $this;
    }

}
