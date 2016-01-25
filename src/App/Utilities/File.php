<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Utilities;

/**
 * File utilities
 */
class File
{

    /**
     * Creates the dir of the filename specified if it's missing
     * @param string $filename The filename
     * @throws \Exception
     * @return void No value is returned
     */
    static function makeDir($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('');
        }
        $pathinfo = pathinfo($filename);
        if (isset($pathinfo['dirname']) && $pathinfo['dirname'] !== '.') {
            \App\Utilities\Dir::make($pathinfo['dirname']);
        }
    }

}
