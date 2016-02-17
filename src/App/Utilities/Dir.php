<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Utilities;

/**
 * Directory utilities
 */
class Dir
{

    /**
     * Creates a dir if it's missing
     * @param string $pathname The pathname of the dir
     * @throws \Exception
     * @return void No value is returned
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
