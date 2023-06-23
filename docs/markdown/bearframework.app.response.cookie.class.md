# BearFramework\App\Response\Cookie

```php
BearFramework\App\Response\Cookie {

	/* Properties */
	public string|null $domain
	public int|null $expire
	public bool|null $httpOnly
	public string|null $name
	public string|null $path
	public bool|null $secure
	public string|null $value

	/* Methods */
	public __construct ( void )
	public array toArray ( [ array $options = [] ] )
	public string toJSON ( [ array $options = [] ] )

}
```

## Properties

##### public string|null $domain

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The (sub)domain that the cookie is available to.

##### public int|null $expire

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The time the cookie expires in unix timestamp format.

##### public bool|null $httpOnly

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;When TRUE the cookie will be made accessible only through the HTTP protocol.

##### public string|null $name

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The name of the cookie.

##### public string|null $path

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The path on the server in which the cookie will be available on.

##### public bool|null $secure

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client.

##### public string|null $value

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The value of the cookie.

## Methods

##### public [__construct](bearframework.app.response.cookie.__construct.method.md) ( void )

##### public array [toArray](bearframework.app.response.cookie.toarray.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as an array.

##### public string [toJSON](bearframework.app.response.cookie.tojson.method.md) ( [ array $options = [] ] )

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns the object data converted as JSON.

## Details

Location: ~/src/App/Response/Cookie.php

---

[back to index](index.md)

