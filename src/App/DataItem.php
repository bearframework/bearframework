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
 * @property \IvoPetkov\DataObject $metadata
 */
class DataItem implements \IvoPetkov\DataObjectInterface
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
        $this->defineProperty('metadata', [
            'init' => function() {
                return new \IvoPetkov\DataObject();
            },
            'readonly' => true
        ]);

        $this->key = $key;
        $this->value = $value;
    }

}
