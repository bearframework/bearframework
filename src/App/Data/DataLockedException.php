<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Data;

class DataLockedException extends \Exception
{

    /**
     * 
     * @param string $message [optional] The Exception message to throw.
     * @param int $code [optional] The Exception code.
     * @param Exception $previous [optional] The previous exception used for the exception chaining.
     */
    public function __construct(string $message = "", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
