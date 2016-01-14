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
class NotFound extends \App\Response
{

    /**
     * 
     * @param string $content
     * @throws \InvalidArgumentException
     */
    function __construct($content = 'Not Found')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }
        parent::__construct($content);
        $this->headers['contentType'] = 'Content-Type: text/plain; charset=UTF-8';
        $this->headers['notFound'] = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.1') . ' 404 Not Found';
    }

}
