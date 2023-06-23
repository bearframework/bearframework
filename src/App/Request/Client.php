<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the client.
 * 
 * @property string|null $ip The client IP address.
 */
class Client
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;

    public function __construct()
    {
        $this
            ->defineProperty('ip', [
                'type' => '?string'
            ]);
    }
}
