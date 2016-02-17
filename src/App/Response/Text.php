<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that outputs text. The appropriate content type is set.
 */
class Text extends \BearFramework\App\Response
{

    /**
     * The constructor
     * @param string $content The content of the response
     * @throws \InvalidArgumentException
     */
    public function __construct($content = '')
    {
        if (!is_string($content)) {
            throw new \InvalidArgumentException('The content argument must be of type string');
        }
        parent::__construct($content);
        $this->setContentType('text/plain');
    }

}
