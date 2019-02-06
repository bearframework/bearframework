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
class PrepareEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $filename
     * @param array $options
     * @property ?string $returnValue
     */
    public function __construct(string $filename, array $options, $returnValue)
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
                ])
        ;
        $this->filename = $filename;
        $this->options = $options;
        $this->returnValue = $returnValue;
    }

}
