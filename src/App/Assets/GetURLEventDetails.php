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
 * @property string|null $url
 */
class GetURLEventDetails
{

    use \IvoPetkov\DataObjectTrait;

    /**
     * 
     * @param string $filename
     * @param array $options
     * @param string|null $url
     */
    public function __construct(string $filename, array $options, string $url = null)
    {
        $this
            ->defineProperty('filename', [
                'type' => 'string'
            ])
            ->defineProperty('options', [
                'type' => 'array'
            ])
            ->defineProperty('url', [ // Todo: Rename to returnValue in v2
                'type' => '?string'
            ]);
        $this->filename = $filename;
        $this->options = $options;
        $this->url = $url;
    }
}
