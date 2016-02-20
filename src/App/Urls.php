<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

use BearFramework\App;

/**
 * URLs utilities
 */
class Urls
{

    /**
     * Constructs a url for the path specified
     * @param string $path The path
     * @throws \InvalidArgumentException
     * @return string Absolute URL containing the base URL plus the path given
     */
    public function get($path = '/')
    {
        if (!is_string($path)) {
            throw new \InvalidArgumentException('');
        }
        $app = &App::$instance;
        return $app->request->base . $path;
    }

}
