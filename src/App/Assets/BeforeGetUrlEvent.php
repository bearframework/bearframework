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
class BeforeGetUrlEvent extends \BearFramework\App\Event
{

    /**
     * 
     * @param string $filename
     * @param array $options
     */
    public function __construct(string $filename, array $options)
    {
        parent::__construct('beforeGetUrl');
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
    }

}
