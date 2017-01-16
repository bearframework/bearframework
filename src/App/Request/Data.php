<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request POST data
 */
class Data implements \Countable
{

    /**
     * The POST data array
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Sets a new POST parameter value
     * 
     * @param string $name The name of the POST parameter
     * @param mixed $value The value of the POST parameter
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Data A reference to the object
     */
    public function set($name, $value)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        $this->data[$name] = $value;
        return $this;
    }

    /**
     * Returns the value of the POST parameter if set
     * 
     * @param string $name The name of the POST parameter
     * @param mixed $defaultValue The value to return if the POST parameter is not found
     * @return mixed|null The value of the POST parameter if set, NULL otherwise
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
     * Returns information whether a POST parameter with the name specified exists
     * 
     * @param string $name The name of the POST parameter
     * @return boolean TRUE if a POST parameter with the name specified exists, FALSE otherwise
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
     * Deletes a POST parameter if exists
     * 
     * @param string $name The name of the POST parameter to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Data A reference to the object
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
     * Returns a list of all POST parameters
     * 
     * @return array An array containing all POST parameters in the following format [['name'=>..., 'value'=>...], ...]
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
     * Returns the number of POST parameter
     * 
     * @return int The number of POST parameter
     */
    public function count()
    {
        return sizeof($this->data);
    }

}
