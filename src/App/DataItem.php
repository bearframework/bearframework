<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property string|null $key
 * @property string|null $value
 * @property \IvoPetkov\DataObject $metadata
 */
class DataItem
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('key', [
            'type' => '?string'
        ]);
        $this->defineProperty('value', [
            'type' => '?string'
        ]);
        $this->defineProperty('metadata', [
            'init' => function() {
                return new \IvoPetkov\DataObject();
            },
            'readonly' => true
        ]);
    }

}
