<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that outputs HTML code. The appropriate content type is set.
 */
class HTML extends \BearFramework\App\Response
{

    /**
     * 
     * @param string $content The content of the response.
     */
    public function __construct(string $content = '')
    {
        parent::__construct($content);
        $this->charset = 'UTF-8';
        $this->headers->set($this->headers->make('Content-Type', 'text/html'));
    }

}
