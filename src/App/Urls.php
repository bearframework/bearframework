<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * URLs utilities.
 */
class Urls
{

    /**
     *
     * @var \BearFramework\App 
     */
    private $app = null;

    /**
     * 
     * @param \BearFramework\App $app
     */
    public function __construct(\BearFramework\App $app)
    {
        $this->app = $app;
    }

    /**
     * Constructs a url for the path specified.
     * 
     * @param string $path The path.
     * @return string Absolute URL containing the base URL plus the path given.
     */
    public function get(string $path = '/')
    {
        return $this->app->request->base . implode('/', array_map('urlencode', explode('/', $path)));
    }

}
