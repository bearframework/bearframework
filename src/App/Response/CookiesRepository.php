<?php

/*
 * Bear Framework
 * http://bearframework.com
 * Copyright (c) 2016 Ivo Petkov
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
     * Sets a cookie
     * 
     * @param \BearFramework\App\Response\Cookie $cookie The cookie to set
     * @return \BearFramework\App\Response\CookiesRepository
     */
    public function set(\BearFramework\App\Response\Cookie $cookie): \BearFramework\App\Response\CookiesRepository
    {
        $this->data[$cookie->name] = $cookie;
        return $this;
    }

    /**
     * Returns the cookie if set
     * 
     * @param string $name The name of the cookie
     * @return BearFramework\App\Response\Cookie|null|mixed The value of the cookie if set, NULL otherwise
     */
    public function get(string $name): ?\BearFramework\App\Response\Cookie
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
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
     * @return \BearFramework\App\Response\CookiesRepository A reference to the repository
     */
    public function delete(string $name): \BearFramework\App\Response\CookiesRepository
    {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
        return $this;
    }

    /**
     * Returns a list of all cookies
     * 
     * @return \BearFramework\DataList|\BearFramework\App\Response\Cookie[] An array containing all cookies in the following format [['name'=>..., 'value'=>...], ...]
     */
    public function getList()
    {
        return new \BearFramework\DataList($this->data);
    }

}
