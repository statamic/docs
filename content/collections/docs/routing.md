---
title: Routing
template: page
intro: Statamic has several ways it routes requests and defines URLs and patterns, all of which are listed and described in this section.
stage: 4
id: 8d9cfb16-36bf-45d0-babb-e501a35ddae6
---
## Overview

All requests to your site are handled by Statamic unless you [create your own Laravel routes](#laravel-routes). Statamic has several ways it routes requests and defines URLs and patterns, all of which are listed and described in this section.

If you want to defer **everything** to explicit Laravel routes (perhaps you're using Statamic as a headless CMS or API), you can disable this behavior by setting in `config/statamic/routing.php`.

``` php
// Lemme do it my way
'enabled' => false,
```

## Content Routes

- [Collections](/collections-and-entries#routing) - each entry often has its own URL.
- [Structures](/structures#routing) can define explicit URLs that are routed to specific templates.
- [Taxonomies](/taxonomies#routing) can have their own URLs.

## Statamic Routes

User-configured Statamic routes live in `config/statamic/routes.php`. Instead of mapping URL patterns to Controllers (like in Laravel), these routes map URL patterns to Statamic [templates](/views#templates). You can also use these routes to pass in additional data and set settings (like `layout`).

``` php
'routes' => [
    '/' => 'home',
    'feed' => [
        'template' => 'rss.feed',
        'layout' => 'rss.layout',
        'content_type' => 'xml',
    ],
    'search' => 'search.index',
],
```

### Content Type Headers

You can control the content type headers by setting `'content_type' => '{content_type}'`. To make your life easier we also support a few shorthand syntaxes for the most common content types. Nobody wants to memorize this stuff, ourselves included.

| Shorthand | Resolves to |
|-----------|-------------|
| `json` | `application/json` |
| `xml` | `text/xml` |
| `atom` | `application/atom+xml` (ensures `utf8` charset) |

## Redirects

Perminant redirects (301) live in `config/statamic/routes.php`.

``` php
'redirect' => [
    '/here' => '/there',
    '/coupon-codes' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
],
```

Vanity (302 temporary) redirects are configured in the `vanity` key.

``` php
'vanity' => [
    '/black-friday' => 'blog/2019/10/black-friday-deals',
],
```


## Laravel Routes

You're free to configure your own regular Laravel routes like you would in a regular app. Plop them in your `routes/web.php` file. Use closures, or point to a [controller](/controllers). This is just [standard Laravel stuff](https://laravel.com/docs/routing).

## Error Pages

Whenever an error is encountered, a view will be rendered based on the status code. It will look for the view in `resources/views/errors/{status}.antlers.html`.

Your standard layout will be used. You can use a custom layout for errors by making sure a `layout.antlers.html` exists in the errors directory.

Statamic will automatically render 404 pages for any unhandled routes.
