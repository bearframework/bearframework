<?php

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
