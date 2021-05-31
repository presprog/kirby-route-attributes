# Kirby routing with attributes

Load routes from `site/routes` and annotate metadata with PHP 8 attributes.
No more business logic in your config files 🎉

****

## Usage

After [installing](#Installation), create a new folder `site/routes`. Then
create a new file for each route you want to add. The filename does not matter,
but every file must return a function, that is annotated with the provided
PHP 8 attributes:

```php
// site/routes/my-awesome-route.php
<?php

use Kirby\Http\Response;
use PresProg\RouteAttributes\Attributes\Get;

return #[Get('/foo/(:all)')] function ($all) {
    return new Response("<h1>$all</h1>", null, 200);
};
```

The following attributes are included:

* [Get](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Get.php)
* [Head](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Head.php)
* [Options](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Options.php)
* [Post](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Post.php)
* [Patch](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Patch.php)
* [Delete](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Delete.php)
* [Connect](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Connect.php)
* [Trace](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Trace.php)

All these attributes share the same base `Route` attribute, which you also may use directly too:
* [Route](https://github.com/presprog/kirby-route-attributes/blob/master/src/Attributes/Route.php)

```php
// site/routes/my-awesome-route.php
<?php

use Kirby\Http\Response;
use PresProg\RouteAttributes\Attributes\Route;

return #[Route('/foo/(:all)', 'GET')] function ($all) {
    return new Response("<h1>$all</h1>", null, 200);
};
```

When developing in `debug` mode, the files will always be read from disk.
When`debug` is `false`, the loaded routes will be read once and then cached.
Make sure to clear the plugin cache after deployment, when you have made
changes to the routes.

****

## Installation

### Composer

```
composer require presprog/kirby-route-attributes
```

### Download

Download and copy this repository to `/site/plugins/route-attributes`.

### Git submodule

```
git submodule add https://github.com/presprog/kirby-route-attributes.git site/plugins/route-attributes
```

## License

MIT

## Credits

**Designed and built with ☕ and ❤ by [Present Progressive](https://www.presentprogressive.de)**
