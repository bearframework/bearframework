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
     * 
     * @param string $dir The directory where the current addon or application are located 
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function __construct(string $dir)
    {
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \InvalidArgumentException('The dir specified does not exist');
        }
        $this->dir = $dir;
    }

    /**
     * Registers a class for autoloading in the current context
     * 
     * @param string $class The class name
     * @param string $filename The filename that contains the class
     * @throws \InvalidArgumentException
     * @return void No value is returned
     */
    public function add(string $class, string $filename): void
    {
        $filename = realpath($this->dir . DIRECTORY_SEPARATOR . $filename);
        if ($filename === false) {
            throw new \InvalidArgumentException('The filename specified does not exist');
        }
        $app = App::get();
        $app->classes->add($class, $filename);
    }

}
