<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Assets;

/**
 * @property string $filename
 * @property array $list
 * @property ?array $returnValue
 */
class BeforeGetDetailsEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $filename
     * @param array $list
     */
    public function __construct(string $filename, array $list)
    {
        $this
            ->defineProperty('filename', [
                'type' => 'string'
            ])
            ->defineProperty('list', [
                'type' => 'array'
            ])
            ->defineProperty('returnValue', [
                'type' => '?array'
            ]);
        $this->filename = $filename;
        $this->list = $list;
    }
}
