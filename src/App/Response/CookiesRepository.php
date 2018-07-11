<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
 * Free to use under the MIT license.
 */

namespace BearFramework\App\Response;

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
     * Constructs a new cookie and returns it.
     * 
     * @var string|null $name The name of the cookie.
     * @var string|null $value The value of the cookie.
     * @return \BearFramework\App\Response\Cookie Returns a new cookie.
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Response\Cookie
    {
        if (self::$newCookieCache === null) {
            self::$newCookieCache = new \BearFramework\App\Response\Cookie();
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
     * Sets a cookie.
     * 
     * @param \BearFramework\App\Response\Cookie $cookie The cookie to set.
     * @return \BearFramework\App\Response\CookiesRepository A reference to itself.
     */
    public function set(\BearFramework\App\Response\Cookie $cookie): \BearFramework\App\Response\CookiesRepository
    {
        $this->data[$cookie->name] = $cookie;
        return $this;
    }

    /**
     * Returns a cookie or null if not found.
     * 
     * @param string $name The name of the cookie.
     * @return BearFramework\App\Response\Cookie|null The cookie requested of null if not found.
     */
    public function get(string $name): ?\BearFramework\App\Response\Cookie
    {
        if (isset($this->data[$name])) {
            return clone($this->data[$name]);
        }
        return null;
    }

    /**
     * Returns information whether a cookie with the name specified exists.
     * 
     * @param string $name The name of the cookie.
     * @return bool TRUE if a cookie with the name specified exists, FALSE otherwise.
     */
    public function exists(string $name): bool
    {
        return isset($this->data[$name]);
    }

    /**
     * Deletes a cookie if exists.
     * 
     * @param string $name The name of the cookie to delete.
     * @return \BearFramework\App\Response\CookiesRepository A reference to itself.
     */
    public function delete(string $name): \BearFramework\App\Response\CookiesRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all cookies.
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Response\Cookie[] An array containing all cookies.
     */
    public function getList()
    {
        $list = new \BearFramework\DataList();
        foreach ($this->data as $cookie) {
            $list[] = clone($cookie);
        }
        return $list;
    }

}
