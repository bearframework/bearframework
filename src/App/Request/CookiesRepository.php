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
class CookiesRepository
{

    /**
     * @var array 
     */
    private $data = [];
    
    /**
     *
     */
    private static $newCookieCache = null;

    /**
     * 
     * @return \BearFramework\App\Request\Cookie
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Request\Cookie
    {
        if (self::$newCookieCache === null) {
            self::$newCookieCache = new \BearFramework\App\Request\Cookie();
        }
        $object = clone(self::$newCookieCache);
        if ($name !== null) {
            $object->name = $name;
        }
        if ($value !== null) {
            $object->value = $value;
        }
        return $object;
    }

    /**
     * Sets a cookie
     * 
     * @param \BearFramework\App\Request\Cookie $cookie The cookie to set
     * @return \BearFramework\App\Request\CookiesRepository
     */
    public function set(\BearFramework\App\Request\Cookie $cookie): \BearFramework\App\Request\CookiesRepository
    {
        $this->data[$cookie->name] = $cookie;
        return $this;
    }

    /**
     * Returns the cookie if set
     * 
     * @param string $name The name of the cookie
     * @return BearFramework\App\Request\Cookie|null|mixed The value of the cookie if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Request\Cookie
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
     * @return \BearFramework\App\Request\CookiesRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Request\CookiesRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all cookies
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Request\Cookie[] An array containing all cookies in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new \BearFramework\DataList($this->data);
    }

}
