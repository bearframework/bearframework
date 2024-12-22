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
 * @property string|null $returnValue
 */
class GetContentEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $filename
     * @param array $options
     * @param string|null $returnValue
     */
    public function __construct(string $filename, array $options, ?string $returnValue = null)
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
        $this->returnValue = $returnValue;
    }
}
