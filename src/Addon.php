<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * @property string $id The id of the addon.
 * @property string $dir The directory where the addon files are located.
 * @property array $options The addon options. Available values:
 *     - require - An array containing the ids of addons that must be added before this one.
 */
class Addon
{

    use \IvoPetkov\DataObjectTrait;

    function __construct(string $id, string $dir, array $options = [])
    {
        $this->defineProperty('id', [
            'type' => 'string'
        ]);
        $this->defineProperty('dir', [
            'type' => 'string',
            'set' => function($value) {
                $dir = realpath($value);
                if ($dir === false) {
                    throw new \InvalidArgumentException('The dir specified does not exist');
                }
                return $dir;
            }
        ]);
        $this->defineProperty('options', [
            'type' => 'array'
        ]);

        $this->id = $id;
        $this->dir = $dir;
        $this->options = $options;
    }

}
