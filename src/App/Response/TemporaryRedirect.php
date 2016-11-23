<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that makes temporary redirect
 */
class TemporaryRedirect extends \BearFramework\App\Response
{

    /**
     * The constructor
     * 
     * @param string $url The redirect url
     * @throws \InvalidArgumentException
     */
    public function __construct($url)
    {
        if (!is_string($url)) {
            throw new \InvalidArgumentException('The url argument must be of type string');
        }
        parent::__construct('');
        $this->statusCode = 307;
        $this->headers->set('Content-Type', 'text/plain');
        $this->headers->set('Location', $url);
    }

}
