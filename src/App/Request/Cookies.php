<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the request cookies
 */
class Cookies implements \Countable
{

    /**
     * The cookies data array
     * 
     * @var array 
     */
    private $data = [];

    /**
     * Sets a new cookie value
     * 
     * @param string $name The name of the cookie
     * @param string $value The value of the cookie
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Cookies A reference to the object
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
     * Returns the value of the cookie if set
     * 
     * @param string $name The name of the cookie
     * @param mixed $defaultValue The value to return if the cookie is not found
     * @return string|null The value of the cookie if set, NULL otherwise
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
     * Returns information whether a cookie with the name specified exists
     * 
     * @param string $name The name of the cookie
     * @return boolean TRUE if a cookie with the name specified exists, FALSE otherwise
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
     * Deletes a cookie if exists
     * 
     * @param string $name The name of the cookie to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\Cookies A reference to the object
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
     * Returns a list of all cookies
     * 
     * @return \BearFramework\App\Request\CookiesList|\BearFramework\App\Request\CookiesListObject[] An array containing all cookies in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        $list = new CookiesList();
        foreach ($this->data as $name => $value) {
            $list[] = new CookiesListObject([
                'name' => $name,
                'value' => $value
            ]);
        }
        return $list;
    }

    /**
     * Returns the number of cookies
     * 
     * @return int The number of cookies
     */
    public function count()
    {
        return sizeof($this->data);
    }

}

/**
 * 
 */
class CookiesList extends \IvoPetkov\DataList
{
    
}

/**
 * @property string $name
 * @property string $value
 */
class CookiesListObject extends \IvoPetkov\DataObject
{
    
}
