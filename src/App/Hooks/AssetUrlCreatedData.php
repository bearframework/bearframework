<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Hooks;

/**
 * @property string $filename The file that is returned as a response.
 * @property array $options URL options. You can resize the file by providing "width", "height" or both.
 * @property string|null $url The url to return.
 */
class AssetUrlCreatedData
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('filename', [
            'type' => 'string'
        ]);
        $this->defineProperty('options', [
            'type' => 'array'
        ]);
        $this->defineProperty('url', [
            'type' => '?string'
        ]);
    }

}
