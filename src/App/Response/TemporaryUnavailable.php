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
class TemporaryUnavailable extends \App\Response
{

    /**
     * 
     * @param string $content
     * @throws \InvalidArgumentException
     */
    function __construct($content = 'Temporary Unavailable')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }
        parent::__construct($content);
        $this->setContentType('text/plain');
        $this->setStatusCode(503);
    }

}
