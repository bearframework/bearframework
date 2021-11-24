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
 * @property array $options
 * @property ?string $returnValue
 */
class BeforeGetURLEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $filename
     * @param array $options
     */
    public function __construct(string $filename, array $options)
    {
        $this
            ->defineProperty('filename', [
                'type' => 'string'
            ])
            ->defineProperty('options', [
                'type' => 'array'
            ])
            ->defineProperty('returnValue', [
                'type' => '?string'
            ]);
        $this->filename = $filename;
        $this->options = $options;
    }
}
