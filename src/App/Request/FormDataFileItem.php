<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * @property string $filename The temporary filename where the uploaded file was stored.
 * @property int|null $size The size, in bytes, of the uploaded file.
 * @property string|null $type The mime type of the file, if the browser provided this information.
 */
class FormDataFileItem extends FormDataItem
{

    public function __construct()
    {

        parent::__construct();
        $this
                ->defineProperty('filename', [
                    'type' => 'string'
                ])
                ->defineProperty('size', [
                    'type' => '?int'
                ])
                ->defineProperty('type', [
                    'type' => '?string'
                ]);
    }

}
