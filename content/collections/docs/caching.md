---
title: Caching
intro: A flat-file CMS wouldn't be worth its salt or sandwiches without a few different intellegent caching mechanisms. Let's explore them.
id: bde2385f-5fee-4cb1-a516-5fe2e2d17e0c
blueprint: page
---
## The Stache

_Purpose: Replaces the database_

Instead of parsing and loading content files on the fly, Statamic uses a cache-based storage layer affectionately named the "Stache". Think of it like Tom Sellek's face if it were a flat-file database.

<figure class='bg-mint'>
    <img src="/img/tom-selleck-lg.jpg" alt="Tom Sellek as Magnum P.I.">
    <figcaption>Behold, the Stache!</figcaption>
</figure>

Rather than using a database as a storage layer, Statamic compiles the data in your content files into an efficient index-based system that is then stored in Laravel's application cache. This stache can be rebuilt from scrach at any time. This is often done when content changes or changes to the site are deployed to a production server.

You cannot disable it, nor would you want to. You can clear it using `php please stache:clear`, rebuild it using `php please stache:warm`, and do both together using `php please stache:refresh`.

The Stache can be configured to improve your site's performance. [Read more about the Stache](/stache).


## Application Cache

_Purpose: Make site faster_

The application cache is used by your site or application, packages, and Statamic to store data for pre-defined lengths of time, much like sessions or cookies might do on the browser side. It uses [Laravel’s cache API](https://laravel.com/docs/6.x/cache). For example, the [Image Transform](/tags/glide) feature uses this cache to store all the manipulated images at their various sizes.

Each item inserted into the cache can optionally and automatically expire after a specified length of time. If you want to clear everything at once, use the `php artisan cache:clear` command.

> The Stache is stored **in** the application cache, so if you clear it, you don't need to also clear the Stache.


## View Fragments

_Purpose: Make a view faster_

There are times when you may want to simply cache a section of an Antlers template to reduce load times for a particularly "expensive" bit of logic or content fetching. That’s where the [cache tag](/tags/cache) comes in. Wrap your markup in `{{ cache }}` tags, specify a duration, and your site is zippy and one might say quite delicious once again.

```
{{ cache for="1 hour" }}
  // something amazing but slow here
{{ /cache }}
```

## Static Caching

_Purpose: Ultimate speed at the cost of dynamic features_

There is nothing faster on the web than static pages, except static pages without JavaScript and giant hero images, of course. And to that end, Statamic can cache static pages and pass routing off to Apache or Nginx through reverse proxying. It sounds much harder than is.

[Read more about Static Caching](/static-caching) to see your sites fly! We're talking `2ms` response times.
