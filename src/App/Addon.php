<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property-read string $id The id of the addon.
 * @property-read string $dir The directory where the addon files are located.
 * @property-read array $options The options of the addon.
 */
class Addon
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $id
     * @param string $dir
     * @param array $options
     */
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
