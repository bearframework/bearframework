<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * The null logger does not log any data and does not throw any errors.
 */
class NullLogger implements ILogger
{

    /**
     * Logs the data specified.
     * 
     * @param string $name The name of the log context.
     * @param string $message The message that will be logged.
     * @param array $data Additional information to log.
     * @return void No value is returned.
     */
    public function log(string $name, string $message, array $data = []): void
    {
    }
}
