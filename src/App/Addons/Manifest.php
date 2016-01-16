<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace App\Addons;

class Manifest
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
    public $version = '';

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
     * @var string 
     */
    public $updateUrl = '';

    /**
     *
     * @var array 
     */
    public $authors = [];

    /**
     *
     * @var array 
     */
    public $media = [];

    /**
     *
     * @var array 
     */
    public $options = [];

}
