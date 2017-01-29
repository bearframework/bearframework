<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
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
    private static $appClassesReference = null;

    /**
     * 
     * @param string $dir The directory where the current addon or application are located.
     */
    public function __construct(string $dir)
    {
        $this->dir = $dir;
        self::$appClassesReference = App::get()->classes;
    }

    /**
     * Registers a class for autoloading in the current context.
     * 
     * @param string $class The class name.
     * @param string $filename The filename that contains the class.
     * @return \BearFramework\App\Context\Classes A reference to itself.
     */
    public function add(string $class, string $filename): \BearFramework\App\Context\Classes
    {
        self::$appClassesReference->add($class, $this->dir . DIRECTORY_SEPARATOR . $filename);
        return $this;
    }

}
