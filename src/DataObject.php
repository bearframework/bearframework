<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework;

/**
 * 
 */
class DataObject implements \ArrayAccess
{

    use \IvoPetkov\DataObjectTrait;
    use \IvoPetkov\DataObjectArrayAccessTrait;
    use \IvoPetkov\DataObjectToArrayTrait;
    use \IvoPetkov\DataObjectFromArrayTrait;
    use \IvoPetkov\DataObjectToJSONTrait;
    use \IvoPetkov\DataObjectFromJSONTrait;
}
