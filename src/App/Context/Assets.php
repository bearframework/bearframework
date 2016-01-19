<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Context;

class Assets
{

    /**
     *
     * @var string 
     */
    private $dir = '';

    /**
     * 
     * @param string $dir
     * @throws \InvalidArgumentException
     */
    function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        $this->dir = $dir;
    }

    /**
     * 
     * @param string $filename
     * @param array $options
     * @return string
     * @throws \InvalidArgumentException
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
