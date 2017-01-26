<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * @property string|null $id The id of the addon.
 * @property string|null $dir The directory where the addon files are located.
 * @property array $options The addon options. Available values:
 *     - require - An array containing the ids of addons that must be added before this one.
 */
class Addon
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('id', [
            'type' => '?string'
        ]);
        $this->defineProperty('dir', [
            'type' => '?string'
        ]);
        $this->defineProperty('options', [
            'type' => 'array'
        ]);
    }

}
