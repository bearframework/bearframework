<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * 
 */
class Request
{

    /**
     *
     * @var string 
     */
    public $method = '';

    /**
     *
     * @var string 
     */
    public $scheme = '';

    /**
     *
     * @var string 
     */
    public $host = '';

    /**
     *
     * @var string 
     */
    public $base = '';

    /**
     *
     * @var \App\Request\Path 
     */
    public $path = null;

    /**
     *
     * @var \App\Request\Query 
     */
    public $query = null;

    /**
     * 
     */
    function __construct()
    {
        $this->path = new \App\Request\Path();
        $this->query = new \App\Request\Query();
    }

    /**
     * 
     * @return string
     */
    function __toString()
    {
        return $this->base . (string) $this->path;
    }

}
