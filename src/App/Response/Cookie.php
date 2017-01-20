<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * @property string $name The name of the cookie.
 * @property string $value The value of the cookie.
 * @property ?int $expire The time the cookie expires in unix timestamp format.
 * @property ?string $path The path on the server in which the cookie will be available on.
 * @property ?string $domain The (sub)domain that the cookie is available to.
 * @property ?bool $secure Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client.
 * @property ?bool $httpOnly When TRUE the cookie will be made accessible only through the HTTP protocol.
 */
class Cookie
{

    use \IvoPetkov\DataObjectTrait;

    function __construct(string $name, string $value)
    {
        $this->defineProperty('name', [
            'type' => 'string'
        ]);
        $this->defineProperty('value', [
            'type' => 'string'
        ]);
        $this->defineProperty('expire', [
            'type' => '?int'
        ]);
        $this->defineProperty('path', [
            'type' => '?string'
        ]);
        $this->defineProperty('domain', [
            'type' => '?string'
        ]);
        $this->defineProperty('secure', [
            'type' => '?bool'
        ]);
        $this->defineProperty('httpOnly', [
            'type' => '?bool'
        ]);

        $this->name = $name;
        $this->value = $value;
    }

}
