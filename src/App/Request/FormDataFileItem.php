<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * @property string $filename The temporary filename of the file in which the uploaded file was stored on the server.
 * @property ?int $size The size, in bytes, of the uploaded file.
 * @property ?string $type The mime type of the file, if the browser provided this information.
 */
class FormDataFileItem extends FormDataItem
{

    function __construct(string $name, string $value)
    {

        parent::__construct($name, $value);
        $this->defineProperty('filename', [
            'type' => 'string'
        ]);
        $this->defineProperty('size', [
            'type' => '?int'
        ]);
        $this->defineProperty('type', [
            'type' => '?string'
        ]);
    }

}
