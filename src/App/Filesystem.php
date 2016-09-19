<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Filesystem utilities
 */
class Filesystem
{

    /**
     * Creates a dir if it's missing
     * @param string $pathname The pathname of the dir
     * @throws \Exception
     * @return void No value is returned
     */
    public function makeDir($pathname)
    {
        if (!is_string($pathname)) {
            throw new \InvalidArgumentException('The pathname argument must be of type string');
        }
        if (!is_dir($pathname)) {
            mkdir($pathname, 0777, true);
        }
    }

    /**
     * Creates the dir for the filename specified if it's missing
     * @param string $filename The filename
     * @throws \Exception
     * @return void No value is returned
     */
    public function makeFileDir($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }
        $pathinfo = pathinfo($filename);
        if (isset($pathinfo['dirname']) && $pathinfo['dirname'] !== '.') {
            $this->makeDir($pathinfo['dirname']);
        }
    }

}
