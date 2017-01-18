<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that outputs JSON code. The appropriate content type is set.
 */
class JSON extends \BearFramework\App\Response
{

    /**
     * The constructor
     * 
     * @param string $content The content of the response
     */
    public function __construct(string $content = '')
    {
        parent::__construct($content);
        $this->charset = 'UTF-8';
        $this->headers->set(new Header('Content-Type', 'text/json'));
    }

}
