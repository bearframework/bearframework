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
 * Provides functionality for autoloading classes in the current context
 */
class Classes
{

    /**
     *
     * @var string 
     */
    private $dir = '';

    /**
     * The constructor
     * @param string $dir The directory where the current addon or application are located 
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        $this->dir = $dir;
    }

    /**
     * Registers a class for autoloading in the current context
     * @param string $class The class name
     * @param string $filename The filename that contains the class
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function add($class, $filename)
    {
        if (!is_string($class)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $app = &App::$instance;
        $app->classes->add($class, $this->dir . $filename);
    }

}
