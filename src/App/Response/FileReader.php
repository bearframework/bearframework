<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Response;

/**
 * Response type that reads file and outputs it
 */
class FileReader extends \App\Response
{

    /**
     * The filename to output
     * @var string 
     */
    public $filename = '';

    /**
     * The constructor 
     * @param string $filename The filename to output
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
