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
 * Provides utility functions for assets in the current context
 */
class Assets
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
     * Registers a directory that will be publicly accessible relative to the current addon or application location
     * @param string $pathname The directory name
     * @return void No value is returned
     */
    public function addDir($pathname)
    {
        $app = &App::$instance;
        $app->assets->addDir($this->dir . $pathname);
    }

    /**
     * Returns a public URL for the specified filename in the current context
     * @param string $filename The filename
     * @param array $options URL options. You can resize the file by providing "width", "height" or both.
     * @throws \InvalidArgumentException
     * @return string The URL for the specified filename and options
     */
    public function getUrl($filename, $options = [])
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $app = &App::$instance;
        return $app->assets->getUrl($this->dir . $filename, $options);
    }

}
