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
     * Sets a new cookie value
     * 
     * @param string $name The name of the cookie
     * @param string $value The value of the cookie
     * @param array $options List of options: Available values:
     *    - int $expire The time the cookie expires in unix timestamp format
     *    - string $path The path on the server in which the cookie will be available on
     *    - string $domain The (sub)domain that the cookie is available to
     *    - boolean $secure Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client
     *    - boolean $httpOnly When TRUE the cookie will be made accessible only through the HTTP protocol
     * @throws \InvalidArgumentException
     * @return \BearFramework\App\Response\Cookie A reference to the object
     */
    public function set($name, $value, $options = [])
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException('The name argument must be of type string');
        }
        if (!is_string($value)) {
            throw new \InvalidArgumentException('The value argument must be of type string');
        }
        if (!is_array($options)) {
            throw new \InvalidArgumentException('The options argument must be of type array');
        }
        if (isset($options['expire']) && !is_int($options['expire'])) {
            throw new \InvalidArgumentException('The expire option must be of type int');
        }
        if (isset($options['path']) && !is_string($options['path'])) {
            throw new \InvalidArgumentException('The path option must be of type string');
        }
        if (isset($options['domain']) && !is_string($options['domain'])) {
            throw new \InvalidArgumentException('The domain option must be of type string');
        }
        if (isset($options['secure']) && !is_bool($options['secure'])) {
            throw new \InvalidArgumentException('The secure option must be of type boolean');
        }
        if (isset($options['httpOnly']) && !is_bool($options['httpOnly'])) {
            throw new \InvalidArgumentException('The httpOnly option must be of type boolean');
        }
        $this->data[$name] = [
            'value' => $value,
            'expire' => isset($options['expire']) ? $options['expire'] : 0,
            'path' => isset($options['path']) ? $options['path'] : null,
            'domain' => isset($options['domain']) ? $options['domain'] : null,
            'secure' => isset($options['secure']) ? $options['secure'] : null,
            'httpOnly' => isset($options['httpOnly']) ? $options['httpOnly'] : false
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
     * @return \BearFramework\App\Response\CookiesList|\BearFramework\App\Response\CookiesListObject[] An array containing all cookies in the following format [['name'=>..., 'value'=>..., 'expire'=>...], ...]
     */
    public function getList()
    {
        $list = new CookiesList();
        foreach ($this->data as $name => $value) {
            $list[] = new CookiesListObject(array_merge(['name' => $name], $value));
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
 * @property int $expire
 * @property string|null $path
 * @property string|null $domain
 * @property bool|null $secure
 * @property bool|null $httpOnly
 */
class CookiesListObject extends \IvoPetkov\DataObject
{
    
}
