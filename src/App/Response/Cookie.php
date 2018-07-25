<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * @property string|null $name The name of the cookie.
 * @property string|null $value The value of the cookie.
 * @property int|null $expire The time the cookie expires in unix timestamp format.
 * @property string|null $path The path on the server in which the cookie will be available on.
 * @property string|null $domain The (sub)domain that the cookie is available to.
 * @property bool|null $secure Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client.
 * @property bool|null $httpOnly When TRUE the cookie will be made accessible only through the HTTP protocol.
 */
class Cookie
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;

    function __construct()
    {
        $this
                ->defineProperty('name', [
                    'type' => '?string'
                ])
                ->defineProperty('value', [
                    'type' => '?string'
                ])
                ->defineProperty('expire', [
                    'type' => '?int'
                ])
                ->defineProperty('path', [
                    'type' => '?string'
                ])
                ->defineProperty('domain', [
                    'type' => '?string'
                ])
                ->defineProperty('secure', [
                    'type' => '?bool'
                ])
                ->defineProperty('httpOnly', [
                    'type' => '?bool'
                ]);
    }

}
