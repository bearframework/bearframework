<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016-2017 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Hooks;

/**
 * @property string|null $filename The image filename.
 * @property int|null $width The width of the image.
 * @property int|null $height The height of the image.
 */
class ImageGetSizeData
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('filename', [
            'type' => '?string'
        ]);
        $this->defineProperty('width', [
            'type' => '?int'
        ]);
        $this->defineProperty('height', [
            'type' => '?int'
        ]);
    }

}
