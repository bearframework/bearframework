<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * @property string|null $name The name of the query parameter.
 * @property string|null $value The value of the query parameter.
 */
class QueryItem
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('name', [
            'type' => '?string'
        ]);
        $this->defineProperty('value', [
            'type' => '?string'
        ]);
    }

}
