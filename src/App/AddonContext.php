<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App;

/**
 * Provides information about the addon location and utility functions
 */
class AddonContext extends \BearFramework\App\Context
{

    /**
     * The addon options
     * @var array 
     */
    public $options;

    /**
     * The constructor
     * @param string $dir The directory where the current addond is located 
     * @throws \InvalidArgumentException
     */
    public function __construct($dir)
    {
        if (!is_string($dir)) {
            throw new \InvalidArgumentException('The dir argument must be of type string');
        }
        $dir = realpath($dir);
        if ($dir === false) {
            throw new \InvalidArgumentException('The dir specified does not exist');
        }
        parent::__construct($dir);
    }

}
