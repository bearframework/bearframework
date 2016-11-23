<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Response type that reads file and outputs it
 * 
 * @property string $filename The filename to output
 */
class FileReader extends \BearFramework\App\Response
{

    /**
     * The filename to output
     * 
     * @var string 
     */
    private $filename = '';

    /**
     * The constructor 
     * 
     * @param string $filename The filename to output
     * @throws \InvalidArgumentException
     */
    public function __construct($filename)
    {
        parent::__construct('');
        $this->__set('filename', $filename);
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return mixed
     * @throws \Exception
     */
    public function __get($name)
    {
        if ($name === 'filename') {
            return $this->filename;
        }
        return parent::__get($name);
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @param mixed $value
     * @throws \Exception
     */
    public function __set($name, $value)
    {
        if ($name === 'filename') {
            if (!is_string($value)) {
                throw new \InvalidArgumentException('The filename argument must be of type string');
            }
            $value = realpath($value);
            if ($value === false || !is_readable($value)) {
                throw new \InvalidArgumentException('The filename specified does not exist or is not readable');
            }
            $this->filename = $value;
        }
        parent::__set($name, $value);
    }

    /**
     * Magic method
     * 
     * @param string $name
     * @return boolean
     */
    public function __isset($name)
    {
        if ($name === 'filename') {
            return true;
        }
        return parent::__isset($name);
    }

    /**
     * Magic method
     * 
     * @param string $name
     */
    public function __unset($name)
    {
        if ($name === 'filename') {
            $this->filename = '';
        }
        parent::__unset($name);
    }

}
