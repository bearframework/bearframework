<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Context;

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
    function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        $this->dir = $dir;
    }

    /**
     * Returns a public URL for the specified filename in the current context
     * @param string $filename The filename
     * @param array $options URL options. You can resize the file by providing "width", "height" or both.
     * @throws \InvalidArgumentException
     * @return string The URL for the specified filename and options
     */
    function getUrl($filename, $options = [])
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('');
        }
        $app = &\App::$instance;
        return $app->assets->getUrl($this->dir . $filename, $options);
    }

}
