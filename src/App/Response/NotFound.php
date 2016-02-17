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
     * @param string $content The content of the response
     * @throws \InvalidArgumentException
     */
    public function __construct($content = 'Not Found')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }
        parent::__construct($content);
        $this->setContentType('text/plain');
        $this->setStatusCode(404);
    }

}
