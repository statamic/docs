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

- [Collections](/collections#routing) - each entry often has its own URL.
- [Structures](/structures#routing) can define explicit URLs that are routed to specific templates.
- [Taxonomies](/taxonomies#routing) can have their own URLs.

## Custom Routes

While URLs will be generated for your content and routed automatically, you may wish to create your own routes.

You're free to configure your own regular Laravel routes like you would in a regular app. Plop them in your `routes/web.php` file. Use closures, or point to a [controller](/controllers). This is just [standard Laravel stuff](https://laravel.com/docs/routing).

## Statamic Routes

While dropping a route in your `routes/web.php` will work just fine, you're typically in charge of all the logic, like preparing variables, getting globals if you need them, and fetching the view.

Statamic provides a `Route::statamic()` method that will handle that for you.

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

[More details on the Laravel docs](https://laravel.com/docs/6.x/routing#redirect-routes).

## Error Pages

Whenever an error is encountered, a view will be rendered based on the status code. It will look for the view in `resources/views/errors/{status}.antlers.html`.

Your standard layout will be used. You can use a custom layout for errors by making sure a `layout.antlers.html` exists in the errors directory.

Statamic will automatically render 404 pages for any unhandled routes.
