---
title: Routing
template: page
intro: Statamic has several ways it routes requests and defines URLs and patterns, all of which are listed and described in this section.
stage: 4
id: 8d9cfb16-36bf-45d0-babb-e501a35ddae6
---
## Overview

All requests to your site are handled by Statamic unless you [create your own Laravel routes](#laravel-routes). Statamic has several ways it routes requests and defines URLs and patterns, all of which are listed and described in this section.

If you want to defer **everything** to explicit Laravel routes (perhaps you're using Statamic as a headless CMS or API), you can disable this behavior by setting in `config/statamic/routes.php`.

``` php
// Lemme do it my way
'enabled' => false,
```

## Content Routes
[Collection entries](/collections#routing) and [taxonomy terms](/taxonomies#routing) can have their own URLs as defined by their own flexible route patterns in their respective configuration areas.

## Custom Routes

You can also configure regular Laravel routes much like you would in a regular Laravel application in `routes/web.php`. You can use closures, point to a [controller](/controllers), and so on. This is [standard Laravel stuff](https://laravel.com/docs/routing) and the standard Laravel docs apply.

## Statamic Routes

Statamic provides a `Route::statamic()` method to do all the CMS "magic" for you, like injecting data (globals and system variables, for example), fetching the view. layout, and so on.

``` php
Route::statamic('uri', 'view', ['foo' => 'bar']);
```
```
{{ myglobal }} // globals are available
{{ foo }} // bar
```

The first argument is the URI, the second is the name of the [template](/views#templates), and the third is an optional array of additional data.

### Parameters

You may use wildcard parameters in your routes. This allows you to match multiple URLs with the same route.

``` php
Route::statamic('things/{thing}', 'things.show');
```

The parameter values will be available in your templates. For example, if you visited `/things/foo`:

```
{{ thing }}
```

``` output
foo
```

### Layout

When using `Route::statamic()`, Statamic will automatically inject the selected view into the default layout. You can customize which layout is used by adding a `layout` to the route data.

``` php
Route::statamic('uri', 'view', ['layout' => 'custom']);
```

### Content Type Headers

You can control the content type headers by setting `'content_type' => '{content_type}'`. To make your life easier we also support a few shorthand syntaxes for the most common content types. Nobody wants to memorize this stuff, ourselves included.

| Shorthand | Resolves to |
|-----------|-------------|
| `json` | `application/json` |
| `xml` | `text/xml` |
| `atom` | `application/atom+xml` (ensures `utf8` charset) |

## Redirects

Creating redirects can be done in your `routes/web.php` using native Laravel Route methods:

``` php
Route::redirect('/here', '/there');
Route::redirect('/here', '/there', 301);
Route::permanentRedirect('/here', '/there');
```

[More details on the Laravel docs](https://laravel.com/docs/routing#redirect-routes).

## Error Pages

Whenever an error is encountered, a view will be rendered based on the status code. It will look for the view in `resources/views/errors/{status_code}.antlers.html`.

You can use a custom layout for errors by creating a `resources/views/errors/layout.antlers.html` view.

Statamic will automatically render `404` pages for any unhandled routes.
