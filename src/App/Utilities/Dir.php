<?php

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
