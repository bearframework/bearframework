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
class TemporaryRedirect extends \App\Response
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
        $this->headers['contentType'] = 'Content-Type: text/plain; charset=UTF-8';
        $this->headers['temporaryRedirect'] = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1') . ' 307 Temporary Redirect';
        $this->headers['location'] = 'Location: ' . $url;
    }

}
