<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Construct the exception
 * @param string $message [optional] The Exception message to throw.
 * @param int $code [optional] The Exception code.
 * @param Exception $previous [optional] The previous exception used for the exception chaining. 
 */
class InvalidConfigOptionException extends \Exception
{

    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
