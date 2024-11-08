---
title: Cache
description: Caches a view chunk for performance gains
intro: >
  If you find that a particular chunk of your view logic is the cause of a performance hit — perhaps you're fetching and filtering huge amount of content, or pulling data from an API, caching that portion of your template can remove alleviate any slowdown.
parameters:
  -
    name: for
    type: string
    description: 'The length of time to cache this section. Use plain English to specify the length, eg. `2 hours`, `5 minutes`, etc.'
  -
    name: key
    type: string
    description: 'The cache key to be used, if you''d like to manually invalidate this tag pair programmatically.'
  -
    name: scope
    type: 'string'
    description: 'Sets the [cache scope](#scope). Three possible values: `site`, `page` or `user`. Has no effect when using the `key` parameter.'
  -
    name: store
    type: 'string'
    description: 'Sets the [cache store](https://laravel.com/docs/cache#accessing-multiple-cache-stores) the cache tag uses to store and retrieve the cached values.'
stage: 4
id: 1d0d2d1f-734b-4360-af7a-6792bf670bc7
---
## Overview

After an initial render, markup inside a cache tag will be pulled from a cached, statically cached copy until invalidated.

::tabs

::tab antlers
```antlers
{{ cache for="5 minutes" }}
  {{ collection:stocks limit="5000" }}
    <!-- probably lots of stuff happening -->
  {{ /collection:stocks }}
{{ /cache }}
```

::tab blade
```blade
<statamic:cache
  for="5 minutes"
>
  <statamic:collection:stocks
    limit="5000"
  >
    <!-- probably lots of stuff happening -->
  </statamic:collection:stocks>
</statamic:cache>
```
::

:::tip
You can disable the `cache` tag (temporarily) based on the environment. This is great for your local setup.

``` env
STATAMIC_CACHE_TAGS_ENABLED=false
```

``` php
return [
   'cache_tags_enabled' => env('STATAMIC_CACHE_TAGS_ENABLED', true), // [tl! highlight]
   ...
];
```
:::

## Exclusions

You may use the `nocache` tag inside a `cache` tag to keep that section dynamic.

::tabs

::tab antlers
```antlers
{{ cache }}
  this will be cached
  {{ nocache }} this will remain dynamic {{ /nocache }}
  this will also be cached
{{ /cache }}
```
::tab blade
```blade
<statamic:cache>
  this will be cached
  <statamic:nocache> this will remain dynamic </statamic:nocache>
  this will also be cached
</statamic:cache>
```
::

[Read more about the nocache tag](/tags/nocache)

## Invalidation

Caching is handy to speed up parts of your site, but it's not very useful unless it's able to be updated at some stage. Here's how
the tag contents can be invalidated.

### Time

Using the `for` parameter allows you to say how long the tag pair contents should be cached in time.

::tabs

::tab antlers
```antlers
{{ cache for="5 minutes" }} ... {{ /cache }}
```
::tab blade
```blade
<statamic:cache
  for="5 minute"
>
  ...
</statamic:cache>
```
::

### Key

By specifying a `key`, you can invalidate it programmatically.

::tabs

::tab antlers
```antlers
{{ cache key="homepage_stocks" }} ... {{ /cache }}
```
::tab blade
```blade
<statamic:cache
  key="homepage_stocks"
>
  ...
</statamic:cache>
```
::

For example, you could listen for an entry in the `stocks` collection being saved and then bust the key.

``` php
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Statamic\Events\EntrySaved;

class EventServiceProvider
{
    public function boot()
    {
        Event::listen(function (EntrySaved $event) {
            if ($event->entry->collectionHandle() === 'stocks') {
                Cache::forget('homepage_stocks');
            }
        });
    }
}
```

:::warning
Invalidating by `key` won't work if you're using tags. In that case, you should invalidate by flushing the tag.
:::

### Cache clear

The contents of your cache tags are stored in the application cache. Clear that, and you'll see fresh content next visit.

You can clear your cache using the Artisan command:

``` shell
php artisan cache:clear
```

### Tag parameters and contents

It might be useful to know that if you aren't using the `key` parameter, a key is generated behind the scenes based on what
parameters and values you've used, along with what's between the tag pair.

So, if you change your template or parameters, you'll see a fresh version next time you visit the page.


## Scope

The `scope` parameter allows you cache the template chunk either across the whole site (the default behavior), for the current user, or per page.

For example, you might have a "recent articles" list on the sidebar that's the same on every page. Or, your footer navigation is probably the same on every page. You can use the `site` scope for those.

However, your header navigation might have "active" states on it, so you'd want to make sure to cache it per page.

::tabs

::tab antlers
```antlers
{{ cache scope="page" }}
    {{ nav }} ... {{ /nav }}
{{ /cache }}
```
::tab blade
```blade
<statamic:cache
  scope="page"
>
  <statamic:nav> ... </statamic:nav>
</statamic:cache>
```
::

Or if your navigation changes depending on the current user, you want to use the `user` scope:


::tabs

::tab antlers
```antlers
{{ cache scope="user" }}
    {{ nav }} {{ user }} ... {{ /user }} {{ /nav }}
{{ /cache }}
```
::tab blade
```blade
<statamic:cache
  scope="user"
>
  <statamic:nav>
    {{ $user->name }}
  </statamic:nav>
</statamic:cache>
```
::

:::tip
The `scope` parameter has no effect if you use the `key` parameter.
:::


## Static Caching

You're free to use the cache tag on top of [static caching](/static-caching).

You'll probably have static caching disabled during development so you can see your changes without having to continually clear anything.

The cache tag could be a nice compromise to speed up heavy areas for a few minutes at a time. Or, if you have some pages excluded from static caching then the cache tag could be useful there.

Of course, if you *do* have static caching enabled, keep in mind that you aren't going to gain anything by using both at the same time.
