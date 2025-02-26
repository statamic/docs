---
title: Caching
intro: Caching is the life-blood, the secret-sauce, and the wizard behind the curtain of Statamic. There are several caching layers, each with its own purpose. Let's explore each one and its specific purpose.
id: bde2385f-5fee-4cb1-a516-5fe2e2d17e0c
blueprint: page
---
## The Stache

**Purpose:** _Replace the traditional database_

Instead of using a relational database like MySQL as a storage system, Statamic aggregates the data in your content files into an efficient, index-based system and stores it in Laravel's application cache. We call this the "stache", and we like to make mustache jokes about it.

<figure class='bg-mint'>
    <img src="/img/tom-selleck-lg.jpg" alt="Tom Selleck as Magnum P.I.">
    <figcaption>Behold, the stache of all staches!</figcaption>
</figure>

**The stache is ephemeral** and can be blown away and rebuilt from scratch at any time without losing data. This is most often done when content or settings change, or when updates are deployed to a production server.

The [CLI](/cli) has commands to clear, warm, and refresh (clear and then immediately warm) the stache.

``` shell
php please stache:clear
php please stache:warm
php please stache:refresh
```

There are settings you can configure to improve the performance of the stache, just like with a relational database. [Learn more about the Stache](/stache) and its various settings.

:::tip
**You cannot disable the stache** &mdash; it is critical architecture.
:::

## Application Cache

**Purpose:** _Make site faster_

The application cache is used by your site/application, third-party addons, Laravel Packages, and Statamic itself to store queries, data, and the results of resource intensive operations for pre-defined lengths of time. It uses [Laravel’s Cache API](https://laravel.com/docs/cache).

**For example,** the [Image Transform](/tags/glide) feature uses this cache to store all the manipulated images at their various sizes and transformations. When the arguments that generate those manipulations change, the cached images are blown away and new ones are generated and cached.

Each item inserted into the cache can **optionally and automatically** expire after a specified length of time.

If you want to clear the entire application cache at once, use the `artisan cache:clear` command.

``` shell
php artisan cache:clear
```

:::tip
The Stache is stored **inside** the application cache, so if you clear it, you don't need to _also_ clear the Stache.
:::

## View Fragments

**Purpose:** _Make a view faster_

There are times when you may want to simply cache a section of an Antlers template to reduce load times for a particularly "expensive" bit of logic or content fetching. This is where the [cache tag](/tags/cache) comes in.

Wrap your markup in `{{ cache }}` tags, specify a duration, and your site is zippy and, one might say, quite delicious once again.

::tabs

::tab antlers
```antlers
{{ cache for="1 hour" }}
  something impressive but slow here
{{ /cache }}
```
::tab blade
```blade
<s:cache for="1 hour">
  something impressive but slow here
</s:cache>
```
::

## Static Caching

**Purpose:** _Ultimate speed at the cost of dynamic features_

There is nothing faster on the web than static pages, except static pages without JavaScript and giant hero images, of course. Statamic can cache static pages and pass routing off to Apache or Nginx through reverse proxying.

Static Caching can be enabled on a per-page level, allowing you to mix and match dynamic features when needed.

:::tip
This should not be confused with [Static Site Generation](https://github.com/statamic/ssg), which is the fastest possible way to run your site, involving generating actual `.html` files used to serve your site, skipping PHP and the Statamic application entirely.
:::

[Learn more about Static Caching](/static-caching) to make your sites start flying! We're talking `2ms` response times here.
