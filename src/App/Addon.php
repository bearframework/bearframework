<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property-read string $id The id of the addon
 * @property-read string $dir The dir of the addon
 * @property-read array $options The options of the addon
 */
class Addon
{

    use \IvoPetkov\DataObjectTrait;

    function __construct(string $id, string $dir, array $options)
    {
        $this->defineProperty('id', [
            'type' => 'string',
            'get' => function() use ($id) {
                return $id;
            },
            'readonly' => true
        ]);
        $this->defineProperty('dir', [
            'type' => 'string',
            'get' => function() use ($dir) {
                return $dir;
            },
            'readonly' => true
        ]);
        $this->defineProperty('options', [
            'type' => 'array',
            'get' => function() use ($options) {
                return $options;
            },
            'readonly' => true
        ]);
    }

}
