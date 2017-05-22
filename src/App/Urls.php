<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
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
     * Constructs a url for the path specified.
     * 
     * @param string $path The path.
     * @return string Absolute URL containing the base URL plus the path given.
     */
    public function get(string $path = '/')
    {
        $app = App::get();
        return $app->request->base . $path;
    }

}
