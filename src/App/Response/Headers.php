<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

/**
 * Provides information about the response headers
 */
class Headers implements \Countable
{

    /**
     * The headers data array
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Sets a new header value
     * 
     * @param string $name The name of the header
     * @param string $value The value of the header
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Response\Headers A reference to the object
     */
    public function set($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (!is_string($value)) {
            throw new \InvalidArgumentException('The value argument must be of type string');
        }
        $this->data[$name] = $value;
        return $this;
    }

    /**
     * Returns the value of the header if set
     * 
     * @param string $name The name of the header
     * @param mixed $defaultValue The value to return if the header is not found
     * @return string|null The value of the header if set, NULL otherwise
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
     * Returns information whether a header with the name specified exists
     * 
     * @param string $name The name of the header
     * @return boolean TRUE if a header with the name specified exists, FALSE otherwise
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
     * Deletes a header if exists
     * 
     * @param string $name The name of the header to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Response\Headers A reference to the object
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
     * Returns a list of all headers
     * 
     * @return \BearFramework\App\Cache|\BearFramework\App\Context[] An array containing all headers in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        $result = [];
        foreach ($this->data as $name => $value) {
            $result[] = [
                'name' => $name,
                'value' => $value
            ];
        }
        return $result;
    }

    /**
     * Returns the number of headers
     * 
     * @return int The number of headers
     */
    public function count()
    {
        return sizeof($this->data);
    }

}
