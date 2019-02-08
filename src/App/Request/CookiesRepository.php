<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) Ivo Petkov
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
    private $newCookieCache = null;

    /**
     * Constructs a new cookie and returns it.
     * 
     * @var string|null $name The name of the cookie.
     * @var string|null $value The value of the cookie.
     * @return \BearFramework\App\Request\Cookie Returns a new cookie.
     */
    public function make(string $name = null, string $value = null): \BearFramework\App\Request\Cookie
    {
        if ($this->newCookieCache === null) {
            $this->newCookieCache = new \BearFramework\App\Request\Cookie();
        }
        $object = clone($this->newCookieCache);
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
     * @param \BearFramework\App\Request\Cookie $cookie The cookie to set.
     * @return self Returns a reference to itself.
     */
    public function set(\BearFramework\App\Request\Cookie $cookie): self
    {
        $this->data[$cookie->name] = $cookie;
        return $this;
    }

    /**
     * Returns a cookie or null if not found.
     * 
     * @param string $name The name of the cookie.
     * @return BearFramework\App\Request\Cookie|null The cookie requested of null if not found.
     */
    public function get(string $name): ?\BearFramework\App\Request\Cookie
    {
        if (isset($this->data[$name])) {
            return clone($this->data[$name]);
        }
        return null;
    }

    /**
     * Returns a cookie value or null if not found.
     * 
     * @param string $name The name of the cookie.
     * @return string|null The cookie value requested of null if not found.
     */
    public function getValue(string $name): ?string
    {
        if (isset($this->data[$name])) {
            return $this->data[$name]->value;
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
     * @return self Returns a reference to itself.
     */
    public function delete(string $name): self
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all cookies.
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Request\Cookie[] An array containing all cookies.
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
