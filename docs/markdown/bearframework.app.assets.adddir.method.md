# BearFramework\App\Assets::addDir

Registers a directory that will be publicly accessible.

```php
public self addDir ( string $pathname )
```

## Parameters

##### pathname

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The directory name.

## Returns

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Returns a reference to itself.

## Examples

**Example #1 description**

```php
<?php

require '../vendor/autoload.php';

use BearFramework\App;

// Constructs a new Bear Framework application.
$app = new App();

$app->routes
        ->add('/', function() { // Defines a handler for the application home page.
            $response = new App\Response(); // Constructs a new response.
            $response->content = 'This is the home page!'; // Sets the response content.
            return $response; // Returns the response.
        })
        ->add('/products/', function() { // Defines a handler for a request with a path matching "/products/"
            $response = new App\Response(); // Constructs a new response.
            $response->content = 'This is the products page!'; // Sets the response content.
            return $response; // Returns the response.
        })
        ->add('/products/?/', function(App\Request $request) { // Defines a handler for a request with a path staring with "/products/" followed by one more path segment.
            $productSlug = $request->path->getSegment(1); // Retrieves the value of the second segment.
            $response = new App\Response(); // Constructs a new response.
            $response->content = 'This is the page for ' . $productSlug . '!'; // Sets the response content.
            return $response; // Returns the response.
        });

// Finds the response and send it to the client.
$app->run();

```

Location: ~/examples/Routes.php

## See also

##### [BearFramework\App](bearframework.app.class.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;The is the class used to instantiate you application.

##### [BearFramework\App\DataRepository::validate()](bearframework.app.datarepository.validate.method.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Checks if a data item key is valid.

##### [BearFramework\App\DataRepository::set()](bearframework.app.datarepository.set.method.md)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Stores a data item.

## Details

Class: [BearFramework\App\Assets](bearframework.app.assets.class.md)

Location: ~/src/App/Assets.php

---

[back to index](index.md)

