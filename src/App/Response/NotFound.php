<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that sends Not Found status
 */
class NotFound extends \BearFramework\App\Response
{

    /**
     * The constructor
     * 
     * @param string $content The content of the response
     */
    public function __construct(string $content = 'Not Found')
    {
        parent::__construct($content);
        $this->statusCode = 404;
        $this->charset = 'UTF-8';
        $this->headers->set(new Header('Content-Type', 'text/plain'));
    }

}
