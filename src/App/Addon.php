<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * @property string $id The id of the addon
 * @property array $options The options of the addon
 */
class Addon
{

    use \IvoPetkov\DataObjectTrait;

    function __construct(string $id, array $options = [])
    {
        $this->defineProperty('id', [
            'type' => 'string'
        ]);
        $this->defineProperty('options', [
            'type' => 'array'
        ]);

        $this->id = $id;
        $this->options = $options;
    }

}
