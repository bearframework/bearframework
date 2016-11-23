<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request files
 */
class Files implements \Countable
{

    /**
     * The files data array
     * 
     * @var array 
     */
    private $data = [];

    /**
     * The constructor
     */
    public function __construct()
    {
        
    }

    /**
     * Sets a new file value
     * 
     * @param string $name The name of the file
     * @param string $filename The original name of the file on the client machine
     * @param string $tempFilename The temporary filename of the file in which the uploaded file was stored on the server
     * @param int $fileSize The size, in bytes, of the uploaded file
     * @param string $type The mime type of the file, if the browser provided this information
     * @param int $errorCode The error code if an error occured. Available values: UPLOAD_ERR_OK, UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE, UPLOAD_ERR_PARTIAL, UPLOAD_ERR_NO_FILE, UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE, UPLOAD_ERR_EXTENSION
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Files A reference to the object
     */
    public function set($name, $filename, $tempFilename, $fileSize, $type = '', $errorCode = 0)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (!is_string($filename)) {
            throw new \InvalidArgumentException('The filename argument must be of type string');
        }
        if (!is_string($tempFilename)) {
            throw new \InvalidArgumentException('The tempFilename argument must be of type string');
        }
        if (!is_int($fileSize)) {
            throw new \InvalidArgumentException('The fileSize argument must be of type string');
        }
        if (!is_string($type)) {
            throw new \InvalidArgumentException('The type argument must be of type string');
        }
        if (!is_int($errorCode)) {
            throw new \InvalidArgumentException('The errorCode argument must be of type string');
        }
        $this->data[$name] = [
            'filename' => $filename,
            'tempFilename' => $tempFilename,
            'fileSize' => $fileSize,
            'type' => $type,
            'errorCode' => $errorCode
        ];
        return $this;
    }

    /**
     * Returns the value of the file if set
     * 
     * @param string $name The name of the file
     * @param mixed $defaultValue The value to return if the file is not found
     * @return string|null The value of the file if set, NULL otherwise
     * @throws \InvalidArgumentException
     */
    public function get($name, $defaultValue = null)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return $defaultValue;
    }

    /**
     * Returns information whether a file with the name specified exists
     * 
     * @param string $name The name of the file
     * @return boolean TRUE if a file with the name specified exists, FALSE otherwise
     * @throws \InvalidArgumentException
     */
    public function exists($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        return isset($this->data[$name]);
    }

    /**
     * Deletes a file if exists
     * 
     * @param string $name The name of the file to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Files A reference to the object
     */
    public function delete($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all files
     * 
     * @return array An array containing all files in the following format [['name'=>..., 'filename'=>...], ...]
     */
    public function getList()
    {
        $result = [];
        foreach ($this->data as $name => $value) {
            $result[] = array_merge(['name' => $name], $value);
        }
        return $result;
    }

    /**
     * Returns the number of files
     * 
     * @return int The number of files
     */
    public function count()
    {
        return sizeof($this->data);
    }

}
