<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

use BearFramework\App\Request\File;
use BearFramework\App\Request\FilesList;

/**
 * Provides information about the response files
 */
class FilesRepository
{

    /**
     * @var array 
     */
    private $data = [];

    /**
     * Sets a file
     * 
     * @param \BearFramework\App\Request\File $file The file to set
     * @return \BearFramework\App\Request\FilesRepository
     */
    public function set(\BearFramework\App\Request\File $file): \BearFramework\App\Request\FilesRepository
    {
        $this->data[$file->name] = $file;
        return $this;
    }

    /**
     * Returns the file if set
     * 
     * @param string $name The name of the file
     * @return BearFramework\App\Request\File|null|mixed The value of the file if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Request\File
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * Returns information whether a file with the name specified exists
     * 
     * @param string $name The name of the file
     * @return boolean TRUE if a file with the name specified exists, FALSE otherwise
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Deletes a file if exists
     * 
     * @param string $name The name of the file to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\FilesRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Request\FilesRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all files
     * 
     * @return \BearFramework\App\Request\FilesList|\BearFramework\App\Request\File[] An array containing all files in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new FilesList($this->data);
    }

}
