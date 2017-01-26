<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that sends Temporary Unavailable status
 */
class TemporaryUnavailable extends \BearFramework\App\Response
{

    /**
     * The constructor
     * 
     * @param string $content The content of the response
     */
    public function __construct(string $content = 'Temporary Unavailable')
    {
        parent::__construct($content);
        $this->statusCode = 503;
        $this->charset = 'UTF-8';
        $this->headers->set($this->headers->make('Content-Type', 'text/plain'));
    }

}
