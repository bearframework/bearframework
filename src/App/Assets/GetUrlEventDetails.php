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
 * @property string $url
 */
class GetURLEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $filename
     * @param array $options
     * @param string $url
     */
    public function __construct(string $filename, array $options, string $url)
    {
        $this
                ->defineProperty('filename', [
                    'type' => 'string'
                ])
                ->defineProperty('options', [
                    'type' => 'array'
                ])
                ->defineProperty('url', [
                    'type' => 'string'
                ])
        ;
        $this->filename = $filename;
        $this->options = $options;
        $this->url = $url;
    }

}
