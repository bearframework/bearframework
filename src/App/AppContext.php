<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

/**
 * Provides information about the application location and utility functions
 */
class AppContext extends \App\Context
{

    /**
     * The constructor
     * @param string $dir The directory where the application is located 
     * @throws \InvalidArgumentException
     */
    function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('');
        }
        parent::__construct($dir);
    }

}
