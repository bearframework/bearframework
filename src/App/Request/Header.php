<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * @property string|null $name The name of the header.
 * @property string|null $value The value of the header.
 */
class Header
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;

    public function __construct()
    {
        $this
            ->defineProperty('name', [
                'type' => '?string'
            ])
            ->defineProperty('value', [
                'type' => '?string'
            ]);
    }
}
