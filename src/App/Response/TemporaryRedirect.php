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
     */
    public function __construct(string $url)
    {
        parent::__construct('');
        $this->statusCode = 307;
        $this->headers
                ->set(new Header('Content-Type', 'text/plain'))
                ->set(new Header('Location', $url));
    }

}
