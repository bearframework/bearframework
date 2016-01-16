<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Utilities;

class Dir
{

    /**
     * 
     * @param string $pathname
     * @throws \Exception
     */
    static function make($pathname)
    {
        if (!is_string($pathname)) {
            throw new \InvalidArgumentException('');
        }
        if (!is_dir($pathname)) {
            mkdir($pathname, 0777, true);
        }
    }

}
