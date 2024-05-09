---
id: 2e0d2f8f-319d-4cce-bd90-16d6ad32ad37
blueprint: page
title: 'REST API'
intro: 'The Content REST API is a **read-only** API for delivering content from Statamic to your frontend, external apps, SPAs, and numerous other possible sources. Content is delivered as JSON data.'
pro: true
---
(If you're interested in [GraphQL](/graphql), we have that too.)

## Enable the API

To enable the REST API, add the following to your `.env` file:

```env
STATAMIC_API_ENABLED=true
```

Or you can enable for all environments in `config/statamic/api.php`:

```php
'enabled' => true,
```

You will also need to [enable the resources](#enable-resources) you want to be available. For security, they're all disabled by default.

### Enable Resources

You can enable resources (ie. Collections, Taxonomies, etc.) in your `config/statamic/api.php` config:

```php
'resources' => [
  'collections' => true,
  'taxonomies' => true,
  // etc
]
```

### Enable Specific Sub-Resources

If you want more granular control over which sub-resources are enabled within a resource type (ie. enabling specific Collection queries only), you can use array syntax:

```php
'resources' => [
    'collections' => [
        'articles' => true,
        'pages' => true,
        // 'events' => false, // Sub-resources are disabled by default
    ],
    'taxonomies' => true,
    // etc.
]
```


## Endpoints

`
https://yourdomain.tld/api/{endpoint}
`
You may send requests to the following endpoints:

- [Entries](#entries) / [Entry](#entry)
- [Collection Tree](#collection-tree) / [Navigation Tree](#navigation-tree)
- [Taxonomy Terms](#taxonomy-terms) / [Taxonomy Term](#taxonomy-term)
- [Assets](#assets) / [Asset](#asset)
- [Globals](#globals) / [Global](#global)
- [Forms](#forms) / [Form](#form)
- [Users](#users) / [User](#user)

### Customizing the API URL
You may customize the route in your API config file or with an environment variable.

```php
// config/statamic/api.php
 'route' => 'not_api',
```

 ```env
 STATAMIC_API_ROUTE=not_api
 ```


## Filtering

### Enabling Filters

For security, [filtering](#filtering) is disabled by default. To enable, you'll need to opt in by defining a list of `allowed_filters` for each sub-resource in your `config/statamic/api.php` config:

```php
'resources' => [
    'collections' => [
        'articles' => [
            'allowed_filters' => ['title', 'status'],
        ],
        'pages' => [
            'allowed_filters' => ['title'],
        ],
        'events' => true, // Enable this collection without filters
        'products' => true, // Enable this collection without filters
    ],
    'taxonomies' => [
        'topics' => [
            'allowed_filters' => ['slug'],
        ],
        'tags' => true, // Enable this taxonomy without filters
    ],
    // etc.
],
```

For endpoints that don't have sub-resources (ie. users), you can define `allowed_filters` at the top level of that resource config:

```php
'resources' => [
    'users' => [
        'allowed_filters' => ['name', 'email'],
    ],
],
```

### Using Filters

You may filter results by using the `filter` query parameter.

``` url
/endpoint?filter[{field}:{condition}]={value}
```

You may use the [conditions](/conditions) available to the collection tag. eg. `contains`, `is`, `isnt` (or `not`), etc. For example:

``` url
/endpoint?filter[title:contains]=awesome&filter[featured]=true
```

This would filter down the results to where the `title` value contains the string `"awesome"`, and the `featured`
value is `true`. When you omit the condition, it defaults to `is`.

### Advanced Filtering Config

You can also allow filters on all enabled sub-resources using a `*` wildcard config. For example, here we'll enable only the `articles`, `pages`, and `products` collections, with `title` filtering enabled on each, in addition to `status` filtering on the `articles` collection specifically: 

```php
'resources' => [
    'collections' => [
        '*' => [
            'allowed_filters' => ['title'], // Enabled for all collections
        ],
        'articles' => [
            'allowed_filters' => ['status'], // Also enable on articles
        ],
        'pages' => true,
        'products' => true,
    ],
],
```

If you've enabled filters using the `*` wildcard config, you can disable filters on a specific sub-resource by setting `allowed_filters` to `false`:

```php
'resources' => [
    'collections' => [
        '*' => [
            'allowed_filters' => ['title'], // Enabled for all collections
        ],
        'articles' => [
            'allowed_filters' => false, // Disable filters on articles
        ],
        'pages' => true,
        'products' => true,
    ],
],
```

Or you can enable endpoints and filters on all sub-resources at once by setting both `enabled` and `allowed_filters` within your `*` wildcard config:

```php
'resources' => [
    'collections' => [
        '*' => [
            'enabled' => true, // All collection endpoints enabled
            'allowed_filters' => ['title'], // With filters enabled for all
        ],
    ],
],
```


## Sorting

You may sort results by using the `sort` query parameter:

``` url
/endpoint?sort=field
```

You can sort in reverse by prefixing the field with a `-`:

``` url
/endpoint?sort=-field
```

You may sort by multiple fields by comma separating them. The reverse flag can be combined with any field:

``` url
/endpoint?sort=one,-two,three
```

You can sort nested fields using the `->` operator, like this: 
```url
/endpoint?sort=nested->field
```

## Selecting Fields

You may specify which top level fields should be included in the response.

``` url
/endpoint?fields=id,title,content
```

## Pagination

Results will be paginated into 25 items per page by default. You may specify the items per page and which page you are viewing with the `limit` and `page` parameters:

``` url
/endpoint?limit=10&page=1
```

The response will contain your `data`, `links` to easily get next/previous URLs, and `meta` information for more easily creating a paginator.

``` json
{
    "data": [
        {...},
        {...},
    ],
    "links": {
        "first": "/endpoint?limit=10&page=1",
        "last": "/endpoint?limit=10&page=3",
        "prev": null,
        "next": "/endpoint?limit=10&page=2",
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "to": 10,
        "total": 29,
        "per_page": 10,
        "path": "/endpoint",
    }
}
```

---

## Entries

`GET` `/api/collections/{collection}/entries`

Gets entries within a collection.

``` json
{
  "data": [
    {
      "title": "My First Day"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

:::tip
If you are using [Multi-Site](/multi-site), the entries endpoint will serve from all sites at once. If needed, you can limit the fetched data to a specific site with a `site` [filter](#filtering) (ie. `&filter[site]=fr`).
:::


## Entry

`GET` `/api/collections/{collection}/entries/{id}`

Gets a single entry.

``` json
{
  "data": {
    "title": "My First Day"
  }
}
```


## Collection Tree

`GET` `/api/collections/{collection}/tree`

Gets entry tree for a structured collection.

``` json
{
  "data": [
    {
      "page": {
        "title": "About",
        "url": "/about"
      },
      "depth": 1,
      "children": [
        {
          "page": {
            "title": "Articles",
            "url": "/about/articles"
          },
          "depth": 2,
          "children": []
        }
      ]
    }
  ]
}
```

### Params

On this endpoint, the [fields](#selecting-fields) param will allow you to select fields within each `page` object. You may also set a `max_depth` to limit nesting depth, or `site` to choose the site.

```url
/api/collections/{collection}/tree?fields=title,url&max_depth=2&site=fr
```


## Navigation Tree

`GET` `/api/navs/{nav}/tree`

Gets tree for a navigation structure.

``` json
{
  "data": [
    {
      "page": {
        "title": "Recommended Products",
        "url": "https://rainforest.store/?cid=statamic",
      },
      "depth": 1,
      "children": [
        {
          "page": {
            "title": "Books",
            "url": "https://rainforest.store/?cid=statamic&type=books",
          },
          "depth": 2,
          "children": []
        }
      ]
    }
  ]
}
```

### Params

On this endpoint, the [fields](#selecting-fields) param will allow you to select fields within each `page` object. You may also set a `max_depth` to limit nesting depth, or `site` to choose the site.

```url
/api/navs/{nav}/tree?fields=title,url&max_depth=2&site=fr
```


## Taxonomy Terms

`GET` `/api/taxonomies/{taxonomy}/terms`

Gets terms in a taxonomy.

``` json
{
  "data": [
    {
      "title": "Music",
    }
  ],
  "links": {...},
  "meta": {...}
}
```

:::tip
If you are using [Multi-Site](/multi-site), you can select the site using a `site` [filter](#filtering) (ie. `&filter[site]=fr`).
:::

## Taxonomy Term

`GET` `/api/taxonomies/{taxonomy}/terms/{slug}`

Gets a single taxonomy term.

``` json
{
  "data": {
    "title": "My First Day"
  }
}
```

## Globals

`GET` `/api/globals`

Gets all globals.

``` json
{
  "data": [
    {
      "handle": "global",
      "api_url": "http://example.com/api/globals/global",
      "foo": "bar",
    },
    {
      "handle": "another",
      "api_url": "http://example.com/api/globals/another",
      "baz": "qux",
    }
  ],
}
```

:::tip
If you are using [Multi-Site](/multi-site), you can select the site using the `site` parameter (ie. `&site=fr`).
:::

## Global

`GET` `/api/globals/{handle}`

Gets a single global set's variables.

``` json
{
  "data": {
    "handle": "global",
    "api_url": "http://example.com/api/globals/global",
    "foo": "bar",
  }
}
```

## Forms

`GET` `/api/forms`

Gets all forms.

``` json
{
  "data": [
    {
      "handle": "contact",
      "title": "Contact",
      "fields": {
        "name": {...},
        "email": {...},
        "inquiry": {...}
      },
      "api_url": "http://example.com/api/forms/contact",
    },
    {
      "handle": "newsletter",
      "title": "Subscribe to Newsletter",
      "fields": {
        "email": {...}
      },
      "api_url": "http://example.com/api/forms/newsletter",
    }
  ],
}
```

## Form

`GET` `/api/forms/{handle}`

Gets a single form.

``` json
{
  "data": {
    "handle": "contact",
    "title": "Contact",
    "fields": {
      "name": {...},
      "email": {...},
      "inquiry": {...}
    },
    "api_url": "http://example.com/api/forms/contact",
  }
}
```

## Users

`GET` `/api/users`

Get users.

``` json
{
  "data": [
    {
      "id": "1",
      "email": "john@smith.com",
      "api_url": "http://example.com/api/users/1"
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## User

`GET` `/api/users/{id}`

Get a single user.

``` json
{
  "data": {
    "id": "1",
    "email": "john@smith.com",
    "api_url": "http://example.com/api/users/1"
  }
}
```

## Assets

`GET` `/api/assets/{container}`

Get a container's asset data.

``` json
{
  "data": [
    {
      "id": "main::foo.jpg",
      "url": "/assets/foo.jpg",
      "api_url": "http://example.com/api/assets/main/foo.jpg",
      "alt": "A picture of nothing."
    }
  ],
  "links": {...},
  "meta": {...}
}
```

## Asset

`GET` `/api/assets/{container}/{path}`

Get a single asset's data.

The `path` in the URL should be the relative path from the container's root.

``` json
{
  "data": {
    "id": "main::foo.jpg",
    "url": "/assets/foo.jpg",
    "api_url": "http://example.com/api/assets/main/foo.jpg",
    "alt": "A picture of nothing."
  }
}
```

## Customizing Resources

By default the resources generally use the item's [Augmented](/augmentation) data.

You are free to override the resource classes with your own, in turn letting you customize the responses.

In a service provider, use the `map` method to define the overriding resources:

``` php
use App\Http\Resources\CustomEntryResource;
use Statamic\Http\Resources\API\Resource;
use Statamic\Http\Resources\API\EntryResource;

class AppServiceProvider extends Provider
{
    public function boot()
    {
        Resource::map([
            EntryResource::class => CustomEntryResource::class,
        ]);
    }
}
```

``` php
<?php

namespace App\Http\Resources;

use Statamic\Http\Resources\API\EntryResource;

class CustomEntryResource extends EntryResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id(),
            'title' => $this->resource->value('title'),
        ];
    }
}
```

## Caching

API responses are cached by default. You may customize the cache expiry in `config/statamic/api.php`.

```php
'cache' => [
    'expiry' => 60,
],
```

### Cache Invalidation

Cached responses are automatically invalidated when content is changed. Depending on your API usage and blueprint schema, you may also wish to ignore specific events when invalidating.

```php
'cache' => [
    'expiry' => 60,
    'ignored_events' => [
        \Statamic\Events\UserSaved::class,
        \Statamic\Events\UserDeleted::class,
    ],
],
```

### Disabling Caching

If you wish to disable caching altogether, set `cache` to `false`.

```php
'cache' => false,
```

### Custom Cache Driver

If you need a more intricate caching solution, you may reference a custom cache driver class and pass extra config along if necessary.

```php
'cache' => [
    'class' => CustomCacher::class,
    'expiry' => 60,
    'foo' => 'bar',
],
```

Be sure to extend `Statamic\API\AbstractCacher` and implement the required methods. You can access custom config via the `config()` method, ie. `$this->config('foo')`.

```php
use Statamic\API\AbstractCacher;

class CustomCacher extends AbstractCacher
{
    public function get(Request $request)
    {
        //
    }

    public function put(Request $request, JsonResponse $response)
    {
        //
    }

    public function handleInvalidationEvent(Event $event)
    {
        //
    }
}
```

## Rate Limiting

The REST API is Rate Limited to **60 requests per minute** by default.

You can change this configuration in your `RouteServiceProvider`. Learn more about [Laravel 8+ Rate Limiting](https://laravel.com/docs/master/rate-limiting).

```php
// app/Providers/RouteServiceProvider.php
protected function configureRateLimiting()
{
    RateLimiter::for('api', function (Request $request) {
        return Limit::perMinute(60);
    });
}
``







## Authentication

**Coming soon.** There are no _native_ access tokens or other common authentication methods ready to use. Yet.
