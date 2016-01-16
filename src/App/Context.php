<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App;

class Context
{

    /**
     *
     * @var string 
     */
    public $dir = '';

    /**
     * 
     * @global \App $app
     * @param string $filename
     * @return boolean
     */
    function loadFile($filename)
    {
        global $app;
        return $app->load($this->dir . $filename);
    }

}
