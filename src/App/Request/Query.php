<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request query string
 */
class Query implements \Countable
{

    /**
     * The query parameters data array
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Sets a new query parameter value
     * 
     * @param string $name The name of the query parameter
     * @param mixed $value The value of the query parameter
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Query A reference to the object
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
     * Returns the value of the query parameter if set
     * 
     * @param string $name The name of the query parameter
     * @param mixed $defaultValue The value to return if the query parameter is not found
     * @return mixed|null The value of the query parameter if set, NULL otherwise
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
     * Returns information whether a query parameter with the name specified exists
     * 
     * @param string $name The name of the query parameter
     * @return boolean TRUE if a query parameter with the name specified exists, FALSE otherwise
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
     * Deletes a query parameter if exists
     * 
     * @param string $name The name of the query parameter to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Query A reference to the object
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
     * Returns a list of all query parameters
     * 
     * @return array An array containing all query parameters in the following format [['name'=>..., 'value'=>...], ...]
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
     * Returns the number of query parameters
     * 
     * @return int The number of query parameters
     */
    public function count()
    {
        return sizeof($this->data);
    }

    /**
     * Returns the full path
     * 
     * @return string The full path
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Returns the full path
     * 
     * @return string The full path
     */
    public function toString()
    {
        return http_build_query($this->data);
    }

}
