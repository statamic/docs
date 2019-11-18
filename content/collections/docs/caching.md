---
title: Caching
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568748305
id: bde2385f-5fee-4cb1-a516-5fe2e2d17e0c
blueprint: page
---

## Stache

Statamic's data storage layer is affectionately named the "Stache". Think of it like Magnum PI's face, if it were a flat-file database.

Rather than placing your data in a database, it converts the data in your content files into a more efficient index-based system. All of the indexes are stored in the cache, which can be rebuilt from scrach at any time.

You cannot disable it, nor would you want to. You can clear it using `php please stache:clear`, rebuild it using `php please stache:warm`, and do both together using `php please stache:refresh`.

The Stache can be configured to improve your site's performance. [Read more about the Stache](/stache)


## Application cache

The application cache is used by your application, packages, and Statamic to store data for defined lengths of time, much like sessions or cookies might do on the browser side. It uses [Laravel’s cache API](https://laravel.com/docs/6.x/cache). As an example, the Image Transform feature uses this cache to store all the manipulated images and their various sizes.

Each item inserted into the cache can optionally automatically expire automatically after a certain length of time. If you want to clear everything at once, you can use `php artisan cache:clear`.

> The Stache is stored **in** the application cache, so if you clear it, you don't need to also clear the Stache.


## Template fragments

There are times when you may want to simply cache a section of an Antlers template to gain some performance. That’s what the [Cache Tag](/tags/cache) is for. Wrap your markup in `{{ cache }}` tags and you’re off on your way to a snappier, zippier, peppier site.

```
{{ cache for="1 hour" }}
  <!-- SO MUCH STUFF HAPPENING HERE DONKEY!
  ...
  1,000 lines later...
  -->
{{ /cache }}
```

## Static caching

Now we get to the **performance** part of the show. There is absolutely nothing faster on the web than static pages (except static pages without javascript and big giant header images, of course). And to that end, Statamic can cache static pages and pass off routing to Apache or Nginx through reverse proxying. It sounds much harder than is.

[Read more about Static Caching](/static-caching) to see your sites fly!