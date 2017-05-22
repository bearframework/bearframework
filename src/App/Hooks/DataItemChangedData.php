<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Hooks;

/**
 * @property string|null $action The action name that changed the data. Available values: set, setValue, append, duplicate, rename, delete, setMetadata, deleteMetadata.
 * @property string|null $key The key of the data item.
 */
class DataItemChangedData
{

    use \IvoPetkov\DataObjectTrait;

    function __construct()
    {
        $this->defineProperty('action', [
            'type' => '?string'
        ]);
        $this->defineProperty('key', [
            'type' => '?string'
        ]);
    }

}
