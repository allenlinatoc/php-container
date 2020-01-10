# allenlinatoc/php-container

PSR-11 compliant container class specifically built for Slim v4, on top of Pimple.

## Installation

**Warning:** This is not yet Production-ready.

`composer require allenlinatoc/php-container "v1.0.1-beta"`  

## Usage

```
AppFactory::setContainer(new Allenlinatoc\Container());
```

Now use it like how you are used to Pimple container.

Assuming you have a Twig PHP file as a service called `twig.php`:

```
<?php

return function ($container) {
    return new \Slim\Views\Twig(
        \Highdesk\Utils\FileSystem::root("/public/views"),
        [
            "cache" => \Highdesk\Utils\FileSystem::root("/.twigcache")
        ]
    );
};
```

You can load it inside container like these:

```
// As array
$container["view"] = (require "twig.php");

// Through "set" method (like PHP-DI's way)
$container->set("view", (require "twig.php"));

// Or as direct property assignment (this is where __set() magic method kicks in)
$container->view = (require "twig.php"); 
```

Now inside Slim's route, you can pull your Twig service like these...
```
$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    
    // As Array
    $this["view"]->render($response, 'index.phtml', compact('name'));
    
    // Through "get" method (like PHP-DI's way)
    $this->get("view")->render($response, 'index.phtml', compact('name'));
    
    // Or as property (via __get() magic method)
    $this->view->render($response, 'index.phtml', compact('name'));
    
    return $response;
});
```

## Explanation

So I'm relatively new to Slim 4 framework. When I was dealing with dependency injection, using PHP-DI container wasn't
good enough for me like how I was used to Pimple container.

In short, I was limited with PSR-11 kind of container e.g. I couldn't do direct property call for any container element:

`$this->container->set("views", (require_once twig.php));`

Now when I try to call Twig service as property...

`$this->view->render(...)`
 
It would tell me undefined property `view` - so I ended up with this simple Container class.

It extends from `\Pimple\Container` and implements `ContainerInterface` so that it would be usable with Slim 4's new
way of loading accommodating container: `AppFactory::setContainer($container)`
