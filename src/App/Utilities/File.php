<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Utilities;

class File
{

    /**
     * 
     * @param string $filename
     * @throws \Exception
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
