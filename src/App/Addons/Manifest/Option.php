<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Addons\Manifest;

class Option
{

    /**
     *
     * @var string 
     */
    public $id = '';

    /**
     *
     * @var string 
     */
    public $type = '';

    /**
     *
     * @var string 
     */
    public $name = '';

    /**
     *
     * @var string 
     */
    public $description = '';

    /**
     *
     * @var array
     */
    public $validations = [];

}
