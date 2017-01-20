<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property string $key
 * @property string $value
 */
class TempDataItem
{

    use \IvoPetkov\DataObjectTrait;

    function __construct(string $key, string $value)
    {
        $this->defineProperty('key', [
            'type' => 'string'
        ]);
        $this->defineProperty('value', [
            'type' => 'string'
        ]);

        $this->key = $key;
        $this->value = $value;
    }

}
