<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * @property string $name The name of the query parameter.
 * @property string $value The value of the query parameter.
 */
class QueryItem implements \IvoPetkov\DataObjectInterface
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

        $this->name = $name;
        $this->value = $value;
    }

}
