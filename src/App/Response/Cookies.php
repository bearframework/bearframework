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
class Cookies implements \Countable
{

    /**
     * The cookies data array
     * 
     * @var array 
     */
    private $data = [];

    /**
     * The constructor
     */
    public function __construct()
    {
        
    }

    /**
     * Sets a new cookie value
     * 
     * @param string $name The name of the cookie
     * @param string $value The value of the cookie
     * @param int $expire The time the cookie expires in unix timestamp format
     * @param string $path The path on the server in which the cookie will be available on
     * @param string $domain The (sub)domain that the cookie is available to
     * @param boolean $secure Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client
     * @param boolean $httpOnly When TRUE the cookie will be made accessible only through the HTTP protocol
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Response\Cookie A reference to the object
     */
    public function set($name, $value, $expire = 0, $path = null, $domain = null, $secure = null, $httpOnly = false)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (!is_string($value)) {
            throw new \InvalidArgumentException('The value argument must be of type string');
        }
        if (!is_int($expire)) {
            throw new \InvalidArgumentException('The expire argument must be of type int');
        }
        if (!is_string($path) && $path !== null) {
            throw new \InvalidArgumentException('The path argument must be of type string');
        }
        if (!is_string($domain) && $domain !== null) {
            throw new \InvalidArgumentException('The domain argument must be of type string');
        }
        if (!is_bool($secure) && $secure !== null) {
            throw new \InvalidArgumentException('The secure argument must be of type boolean');
        }
        if (!is_bool($httpOnly)) {
            throw new \InvalidArgumentException('The httpOnly argument must be of type boolean');
        }
        $this->data[$name] = [
            'value' => $value,
            'expire' => $expire,
            'path' => $path,
            'domain' => $domain,
            'secure' => $secure,
            'httpOnly' => $httpOnly
        ];
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
     * @return \BearFramework\App\Response\Cookie A reference to the object
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
     * @return array An array containing all cookies in the following format [['name'=>..., 'value'=>..., 'expire'=>...], ...]
     */
    public function getList()
    {
        $result = [];
        foreach ($this->data as $name => $value) {
            $result[] = array_merge(['name' => $name], $value);
        }
        return $result;
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
