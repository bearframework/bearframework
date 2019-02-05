<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * Base class for objects.
 * 
 * @codeCoverageIgnore
 */
class DataObject implements \ArrayAccess
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectArrayAccessTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectFromArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;
    use \IvoPetkov\DataObjectFromJSONTrait;

    /**
     * Constructs a new data object.
     * 
     * @param array $data The data to use for the properties values.
     */
    public function __construct(array $data = [])
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
    }

}
