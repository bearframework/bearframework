<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that sends Not Found status.
 */
class NotFound extends \BearFramework\App\Response
{

    /**
     * 
     * @param string $content The content of the response.
     */
    public function __construct(string $content = '')
    {
        parent::__construct($content);
        $this->statusCode = 404;
        $this->charset = 'UTF-8';
        $this->headers->set($this->headers->make('Content-Type', 'text/plain'));
    }
}
