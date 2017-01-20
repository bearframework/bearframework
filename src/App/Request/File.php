<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * @property string $name The name of the file.
 * @property string $tempFilename The temporary filename of the file in which the uploaded file was stored on the server.
 * @property ?string $filename The original name of the file on the client machine.
 * @property ?int $size The size, in bytes, of the uploaded file.
 * @property ?string $type The mime type of the file, if the browser provided this information.
 * @property ?int $errorCode The error code if an error occurred. Available values: UPLOAD_ERR_OK, UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE, UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, UPLOAD_ERR_EXTENSION.
 */
class File
{

    use \IvoPetkov\DataObjectTrait;

    function __construct(string $name, string $tempFilename)
    {
        $this->defineProperty('name', [
            'type' => 'string'
        ]);
        $this->defineProperty('tempFilename', [
            'type' => 'string'
        ]);
        $this->defineProperty('filename', [
            'type' => '?string'
        ]);
        $this->defineProperty('size', [
            'type' => '?int'
        ]);
        $this->defineProperty('type', [
            'type' => '?string'
        ]);
        $this->defineProperty('errorCode', [
            'type' => '?int'
        ]);

        $this->name = $name;
        $this->tempFilename = $tempFilename;
    }

}
