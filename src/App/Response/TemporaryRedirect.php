<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that makes temporary redirect.
 */
class TemporaryRedirect extends \BearFramework\App\Response
{

    /**
     * 
     * @param string $url The redirect URL.
     */
    public function __construct(string $url)
    {
        parent::__construct('');
        $this->statusCode = 307;
        $this->headers
                ->set($this->headers->make('Content-Type', 'text/plain'))
                ->set($this->headers->make('Location', $url));
    }

}
