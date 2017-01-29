<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

interface ILogger
{

    /**
     * 
     * @param string $level
     * @param string $message
     * @param array $context
     * @return void No value is returned.
     */
    public function log(string $level, string $message, array $context = []): void;
}
