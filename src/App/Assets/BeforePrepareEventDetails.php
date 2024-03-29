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
 */
class BeforePrepareEventDetails
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
            ]);
        $this->filename = $filename;
        $this->options = $options;
    }
}
