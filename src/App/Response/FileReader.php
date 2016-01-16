<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Response;

/**
 * 
 */
class FileReader extends \App\Response
{

    /**
     *
     * @var string 
     */
    public $filename = '';

    /**
     * 
     * @param string $filename
     * @throws \InvalidArgumentException
     */
    function __construct($filename)
    {
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }
        $this->filename = $filename;
        parent::__construct('');
    }

}
