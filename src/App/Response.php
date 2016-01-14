<?php

/*
 * App
 * 
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * 
 */
class Response
{

    /**
     *
     * @var string 
     */
    public $content = '';

    /**
     *
     * @var array 
     */
    public $headers = [];

    /**
     * 
     * @param string $content
     * @throws \InvalidArgumentException
     */
    function __construct($content = '')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }
        $this->headers['cacheControl'] = 'Cache-Control: no-store, no-cache, must-revalidate, max-age=0';
        $this->content = $content;
    }

    /**
     * 
     * @param int $seconds
     * @throws \InvalidArgumentException
     */
    function setMaxAge($seconds)
    {
        if (!is_int($seconds) || $seconds < 0) {
            throw new \InvalidArgumentException('The seconds argument must be of type int and non negative');
        }
        $this->headers['cacheControl'] = 'Cache-Control: public, max-age=' . $seconds;
    }

}
