<?php

/*
 * App
 * 
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Response;

/**
 * 
 */
class PermanentRedirect extends \App\Response
{

    /**
     * 
     * @param string $url
     * @throws \InvalidArgumentException
     */
    function __construct($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('The url argument must be of type string');
        }
        parent::__construct('');
        $this->setContentType('text/plain');
        $this->setStatusCode(301);
        $this->headers['location'] = 'Location: ' . $url;
    }

}
