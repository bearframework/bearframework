<?php

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
