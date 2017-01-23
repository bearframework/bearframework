<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Request;

/**
 * Provides information about the response cookies
 */
class QueryRepository
{

    /**
     * @var array 
     */
    private $data = [];

    /**
     * Sets a cookie
     * 
     * @param \BearFramework\App\Request\QueryItem $queryItem The cookie to set
     * @return \BearFramework\App\Request\QueryRepository
     */
    public function set(\BearFramework\App\Request\QueryItem $queryItem): \BearFramework\App\Request\QueryRepository
    {
        $this->data[$queryItem->name] = $queryItem;
        return $this;
    }

    /**
     * Returns the cookie if set
     * 
     * @param string $name The name of the cookie
     * @return BearFramework\App\Request\QueryItem|null|mixed The value of the cookie if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Request\QueryItem
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return null;
    }

    /**
     * Returns the value of the cookie if set
     * 
     * @param string $name The name of the cookie
     * @return string|null|mixed The value of the cookie if set, NULL otherwise
     */
    public function getValue(string $name): ?string
    {
        if (isset($this->data[$name])) {
            return $this->data[$name]->value;
        }
        return null;
    }

    /**
     * Returns information whether a cookie with the name specified exists
     * 
     * @param string $name The name of the cookie
     * @return bool TRUE if a cookie with the name specified exists, FALSE otherwise
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Deletes a cookie if exists
     * 
     * @param string $name The name of the cookie to delete
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Request\QueryRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Request\QueryRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all cookies
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Request\QueryItem[] An array containing all cookies in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new \BearFramework\DataList($this->data);
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
        $temp = [];
        foreach ($this->data as $queryItem){
            $temp[$queryItem->name] = $queryItem->value;
        }
        return http_build_query($temp);
    }

}
