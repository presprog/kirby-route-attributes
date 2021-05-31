# Kirby routing with annotations

Load routes from `site/routes` and annotate meta data with PHP 8 attributes.

****

## Usage

After [installing](#Installation), first create a new folder `site\plugins\routes`. Secondly, create a new file for
each route. The name does not matter, but every file must return a function,
that is annotated with the provided PHP 8 attributes:

```php
// site/plugins/my-awesome-route.php
<?php

use Kirby\Http\Response;
use PresProg\AttributeRouting\Attributes\Get;

return #[Get('/foo/(:all)')] function ($all) {
    return new Response("<h1>$all</h1>", null, 200);
};
```

The following attributes are included:

* [Get](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Get.php)
* [Head](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Head.php)
* [Options](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Options.php)
* [Post](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Post.php)
* [Patch](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Patch.php)
* [Delete](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Delete.php)
* [Connect](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Connect.php)
* [Trace](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Trace.php)

All these attributes share the same base `Route` attribute, which you also may use directly too:
* [Route](https://github.com/presprog/kirby-attribute-routing/blob/master/src/Attributes/Route.php)

```php
// site/plugins/my-awesome-route.php
<?php

use Kirby\Http\Response;
use PresProg\AttributeRouting\Attributes\Route;

return #[Route('/foo/(:all)', 'GET')] function ($all) {
    return new Response("<h1>$all</h1>", null, 200);
};
```

****

## Installation

### Download

Download and copy this repository to `/site/plugins/attribute-routing`.

### Git submodule

```
git submodule add https://github.com/presprog/kirby-attribute-routing.git site/plugins/attribute-routing
```

### Composer

```
composer require presprog/kirby-attribute-routing
```

## License

MIT

## Credits

- [Your Name](https://github.com/ghost)
