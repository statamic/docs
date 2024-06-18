---
id: 7202c698-942a-4dc0-b006-b982784efb03
blueprint: page
title: Collections
intro: 'Collections are containers that hold groups of related entries. Each entry in a collection can represent a blog post, product, recipe, or even chapter of your Family Matters fan fiction novel detailing Steve Urkel''s rise to UFC Heavyweight Champion of the world.'
template: page
related_entries:
  - 7202c698-942a-4dc0-b006-b982784efb03
  - 8d9cfb16-36bf-45d0-babb-e501a35ddae6
  - 6177b316-0eed-4dec-83d1-e5a48a8e00b6
  - dcf80ee6-209e-45aa-af42-46bbe01996e2
  - a6a956fd-647d-4503-9a4a-3b24198e6e73
  - 54548616-fd6d-44a3-a379-bdf71c492c63
  - cb21fabb-65ba-4869-9acd-f6aa2fb58a01
  - 420f083d-99be-4d54-9f81-3c09cb1f97b7
---
## Overview

Not to be redundant, but Collections are simply containers that hold entries. You can think of them like shoeboxes containing love letters, except they're folders on your server and they're holding text documents. So, not exactly the same thing — or at least, not nearly as romantic.

Each collection holds settings that affect all of its entries. Like URL patterns by way of [routes](/routing), which fields are available with [blueprints](/blueprints), as well as any desired [date behaviors](#dates).

You can also set default values like template, blueprint, and published status.

A collection is defined by a YAML file stored in the `content/collections` directory. All accompanying entries will be stored in a sub-directory with a matching name. For example, a `blog` collection looks like this:

``` files theme:serendipity-light
content/collections/
  blog/
    hello.md
    is-it-me.md
    youre-looking-for.md
  blog.yaml
```
## Entries

Each entry — at the very least — has a title, published status, id, and probably some content. The content fields are determined by one or more [blueprints](/blueprints) set on the collection.

Entries are stored as Markdown files inside their collection's respective directory (`content/collections/{collection}/entry.md`). At any time you can edit any entry in your code editor by popping open these files and doing what comes naturally.
### Let's go deeper.

We're going to pretend it's currently the summer of '99 and we are journalists covering the Summer X Games. The weather here in San Fransisco is beautiful and 275,000 people are watching Tony Hawk make history.

Here's an entry we might write about the event.

<figure>
    <img src="/img/entry-tony-hawk.png" alt="An entry being edited in the Statamic control panel">
    <figcaption>Entry publishing with only the default content fields.</figcaption>
</figure>

And here's what the Markdown file would look like:

``` markdown
<!-- content/collections/blog/1999-07-27.tony-hawks-900.md -->
---
title: Tony Hawk lands the first-ever 900
id: 3a28f050-f8d2-4a56-ba8a-314a9d46bf38
---
It took skateboarding legend Tony Hawk 11 tries, but he finally landed a 900 at the 1999 Summer X Games in a moment that launched the sport into popular consciousness in a new way.
```

You can create, edit, and delete entries in the control panel _or_ filesystem, it's up to you and your preference in the heat of moment. Let your passion carry you away.

### View Data

Each entry has its own unique URL. When you're on it, all of the entry's data will be available in your views as variables. If an entry is _missing_ data, intentionally or not, it will fall back to a series of defaults. We call this fallback logic [the cascade](/cascade).

If a value doesn't exist in one place, it'll check the next place, then the next, and so on, in this order:

1. The entry
2. The origin entry (if using localization)
3. The collection


### Setting Default Data {#inject}

**Injecting** data into your collection allows you to provide default values for your entries. If entries have these variables set, they will override the collection _defaults_, but not any data set on the entries themselves.

This is done by adding an `inject` key in your collection's YAML config file.

``` yaml
# /content/collections/blog.yaml [tl! **]
title: Blog
date: true
date_behavior:
  past: public
  future: private
route: 'blog/{slug}'
sort_dir: desc
template: blog/show
inject: #[tl! focus:start]
  author: jason
  show_sidebar: true
  show_newsletter_signup: false #[tl! focus:end]
```

## Blueprints

Each Collection uses blueprints to define the available fields when creating and editing its entries.

If you don't explicitly create a blueprint, your entries will have a basic set of fields: title, markdown content, slug, etc. Of course, you're able to create your own.

If you create _more than_ one blueprint you'll be given the option to choose which one you want when creating a new entry.

You can hide blueprints from appearing in the new entry menu by activating the _Hidden_ toggle on the blueprint's UI or setting `hide: true` in the blueprint's yaml file.

## Titles

All entries need a title. Statamic uses titles to display entries in a consistent way throughout the Control Panel.

Depending on the collection, a dedicated `title` field might not be useful to you. In this case, you may configure a "title format" which would be used to automatically generate titles from other fields.

For example, a "reviews" collection might just have `author`, `stars`, and `content` fields. You could configure the titles to be "5 star rating by John Smith".

<figure>
    <img src="/img/title-format-setting.png" alt="Entry Title Format Setting" width="544" height="120">
    <figcaption>Configuring an automated title</figcaption>
</figure>

When using multiple sites, you may optionally configure the titles on a per site level by using an array:

```yaml
title_format:
  en: '{stars} star rating by {author:name}'
  fr: '{stars} étoiles par {author:name}'
```

It's worth noting that changes to a collection's title format won't change the titles of existing entries. For it to take affect, you will need to re-save your existing entries.

:::tip
To use modifiers in title formats, make sure to use the `{{` Antlers syntax, like this:

```antlers
{{ headline | ucfirst }}
```
:::

## Slugs

Slugs are what you would typically use in entry URLs. For an entry named `My Entry`, the slug might be `my-entry`.

When creating entries in the Control Panel, if you submit an entry with an empty `slug`, one will be generated based on the title.

If the entries in a specific collection don't need to have dedicated URLs, or if the entries' route only contains other fields, a `slug` field may not be useful for you.

You may disable the slug requirement by adding a boolean:

```yaml
slugs: false
```

This will prevent collections from automatically adding a slug field.

:::tip
Since Statamic stores entries as files, it uses the slug for the filename. If you disable slugs, it will use the ID instead. (e.g. `my-entry.md` vs. `123.md`)
:::


## Dates

If your collection requires a date, as they often do, you can decide how Statamic uses it to control default visibility. For example, you can choose to have dates set in the future to be private (404), which effectively allows you to schedule their publish date.

Alternatively, you could have _past_ dates be private which would make entries act like "upcoming events" that disappear from a list when they're over.

<figure>
    <img src="/img/collection-date-behaviors.png" alt="Collection Date Behaviors">
    <figcaption>Just imagine! This could be you, configuring date behaviors.</figcaption>
</figure>

### Available Date Behaviors

Each of these behaviors is available for future and past dates.

- **public** - Entries will be visible in listings and at their own URLs.
- **unlisted** - Entries will be hidden in listings but available at their own URLs.
- **private** - Entries will be hidden in listings, and their own URLs will 404.

:::tip
Date behaviors are _defaults_. They can be overridden at the [tag level](/tags/collection) in your templates.
:::

### Date Behavior and Published Status

You can override [date behavior visibility settings](#available-date-behaviors) on an entry-by-entry basis by setting `published: false` on your entry.

Each entry will automatically be assigned one of four possible computed `status` values, which respects both your collection's date behavior settings, as well as your entry's published setting:

- **published** - Entry is published and visible.
- **scheduled** - Entry is published, but not yet visible because date is upcoming.
- **expired** - Entry is published, but not visible anymore because date has expired.
- **draft** - Entry is explicitly hidden via `published: false`.

:::tip
We recommend [filtering](/tags/collection#published-status) and [querying](/repositories/entry-repository#get-all-published-and-scheduled-entries) against your entry's `status` (instead of its `published` boolean) so that you can more easily take advantage of date behavior logic without hassle.
:::

<figure>
    <img src="/img/collection-published-status-filtering.png" alt="Collection Published Status Filtering">
    <figcaption>Filter by entry status in your collection listings.</figcaption>
</figure>


## Time

To get more granular and introduce _time_, add a [date field](/fieldtypes/date) named `date` to your blueprint and Statamic will respect however you configure it. You can use this approach to have entries publish at a **specific times**, e.g. `11:45am`.

:::tip
If you don't enable the time, all entries on a given day will assume a default time of midnight, or `00:00`. If you want to make sure that multiple entries on the same day are ordered in the order you published them, turn the time on.
:::

## Ordering

Flick on the "Orderable" switch in a collection's settings and you'll have a drag and drop UI in the control panel to order the entries. The collection is now "structured". Learn more about [structures](/structures).


<figure>
    <img src="/img/collection-structure.png" alt="An orderable collection">
    <figcaption>You can tell these entries are orderable because of the way they are.</figcaption>
</figure>

:::tip
Order will take precedence when sorting. For example, if you make a dated collection **orderable**, date will no longer be the default sort order. You still can sort by date by specifying `sort="date"` on your [collection tag](/tags/collection).
:::

### Constraining Depth

A structured collection will **not** have a maximum depth unless you set one, allowing you to nest entries as deep as you like. Set the `max_depth` option to limit this behavior. Setting `max_depth: 1` will replace the tree UI with a flat, table-based UI.

<figure>
    <img src="/img/reorderable-entries.png" alt="An orderable collection with max depth of 1">
    <figcaption>These reorderable entries have a max depth of 1.</figcaption>
</figure>

### Default Sort Order in Listings

For non-structured collections, you can choose which field and direction to sort the list of entries in the Control Panel by setting the `sort_by` and `sort_dir` variables in your collection.yaml. By default the Title field will be used.

## Routing

Entries receive their URLs from their collection's route setting. You can use standard meta variables in addition to the variables from the collection's blueprint to define your route rule. You can even use [computed values](/computed-values) or Antlers to do advanced things.

``` yaml
route: /blog/{slug}
```

If you are building a multi-site and want different routes for different locales:

```yaml
route:
  english: /events/{slug}
  french: /evenements/{slug}
```

:::tip
Statamic does not automatically define route rules. If you want entries in your new collection to have URLs, make sure you define one!
:::

### Meta variables

| Variable | Available |
|----------|-----------|
| `slug` | always |
| `year` | when in a dated collection |
| `month` | when in a dated collection |
| `day` | when in a dated collection |
| `parent_uri` | when in an [orderable](#ordering) collection and max_depth > 1 |
| `depth` | when in an [orderable](#ordering) collection and max_depth > 1 |
| `mount` | when [mounted](#mounting) to an entry |

### Example Routes

Here are a few examples of possible route rules for inspiration. 💡

#### Wordpress Style
``` yaml
route: /news/{year}/{month}/{day}/{slug}
# example: /news/2019/01/01/happy-new-year
```

#### For when you don't care about SEO
``` yaml
route: /{id}
# example: /12345-1234-321-12345
```

#### For when you care _too much_ about SEO
``` yaml
route: /{parent_uri}/{slug}.html
# example: /details/project.html
```

#### Organizing sports brackets with structures
Here's how we use the `depth` variable, along with the `team_name` field from the entry's blueprint.

``` yaml
route: /tournament/round-{depth}/{team_name}
# example: /tournament/round-4/chicago-bulls
```

#### Using fields from related entries
For example, if you have a `category` field in your Products collection and you'd like to your product URLs to depend on it, you can configure a [computed value](/computed-values) to return the category URL, then use that computed value in your collection's route:

``` php
// app/Providers/AppServiceProvider.php

use Statamic\Facades\Collection;

Collection::computed('products', 'category_url', function ($entry, $value) {
    return $entry->category?->url();
});
```

``` yaml
route: '{{ category_url }}/{{ slug }}'
# example: /categories/wooden-toys/steam-locomotive
```

#### Using Antlers to organize gaming articles

You can even use Antlers to get more complicated. Here we'll include the [mounted](#mounting) entry at the top level.

``` yaml
mount: 'id-of-games-page'
route: '{{ depth == 1 ?= mount }}/{{ parent_uri }}/{{ slug }}'
# example: /games/zork/how-to-play/controls
```

:::tip
If you're using Antlers in your route, you must use `{{ double curlies }}` when referencing variables.
:::

### Index route

Once you've set up a route for your entries (e.g. `/blog/{slug}`) you'll usually want an index page listing all your entries as well. It's important to know that Statamic **doesn't** create this for you automatically. You need to either:

- Create an entry in another collection (typically a "pages" collection) that exists as `/blog` and [mount](#mounting) it to your blog collection.
- Create a [custom route](/routing#statamic-routes) that exists at `/blog`.

## Redirects

Adding a `redirect` variable to one of your entries will cause an HTTP redirect when visiting its URL.

``` yaml
---
id: page-book-tickets
title: Book Ticket
redirect: http://booking.mysite.com
```

A particularly useful example of when you might want to do this is if you need an external link in your nav but creating a completely separate nav would be overkill.

The following redirects are supported:
- external links (starting with `http`)
- internal links (starting with `/`)
- other entries or terms (eg. `entry::id-of-entry` or `term::id-of-term`)
- it's first child page (`@child`) - If there are no child pages you will get a 404
- a `404` response

Any other strings will be assumed to be a relative link. For example: if the page URL is `/my/page` and you have `redirect: is/here` in your entry, you will be redirected to `/my/page/is/here`.

By default, Statamic will return a 302 status code when redirecting. To return a different status code, make the `redirect` an array with a `status` key:

```yaml
redirect:
    url: http://booking.mysite.com
    status: 301
```

:::tip
Entries with redirects will get filtered out of the [collection](/tags/collection) tag by default. You can include them by adding a `redirects="true"` parameter.
:::

### Entry Link Blueprint

When a Collection is structured and you have set `Entries in this collection may contain links (redirects) to other entries or URLs.` on in the collection settings, you will be presented with the option to create "Links" along with any other available blueprints when you try to create an entry.

This will load a behind-the-scenes blueprint containing `title` and `redirect` fields. You are free to modify what's shown on these pages by creating your own `entry_link` blueprint.

## Taxonomies

[Taxonomies](/taxonomies) are defined on the _collection level_, not the blueprint-level. This enforces a tighter content-model, and reduces complexity when configuring blueprints.

Let's imagine you have a **product** collection. Each entry is a product, and each product _has one or more_ categories. Thus set, no matter what blueprints you configure, each will have a **categories** field in the sidebar. You'll be able to access any categories on your entries with a `{{ categories }}` variable loop.

### Taxonomies Setting

``` yaml
taxonomies:
  - categories
  - tags
```

## Mounting

You may mount a collection onto an entry as a way of saying "all these entries belong to this section". When you do this, two neat things happen:

- The collection will share the URL of the entry.
- If the entry is listed in a structure, you will see shortcut links to **add or edit** entries in that collection.

<figure>
    <img src="/img/mounted-collection.png" alt="Mounted collections in a structure">
    <figcaption>Look at those add and edit links!</figcaption>
</figure>

### Mount Setting

You can mount a collection to an entry in the collection configure page (or by specifying the ID of the desired entry in the collection's YAML config file). For example, you might mount a **tropical fish** collection to a **aquarium** entry page.

Now you can use `mount` variable in the route to automatically prepend the mounted entry's URL. So for example, if you mounted a collection to `/aquarium` with `/{mount}/{slug}`, all your fish URLs will follow the `/aquarium/entry-url` pattern. If you later move `/aquarium` to `/house-of-fishies`, all your entries will automatically update with `/house-of-fishies/entry-url`.

``` yaml
title: Our Tropical Fishies
mount: id-of-the-aquarium-entry
route: '/{mount}/{slug}'
```

### Looping through mounted entries

You can loop through all entries in the the mounted collection easily by using the `{{ collection }}` tag and setting the `from` value to bind to the mounted collection using `mount`, like so.

```antlers
{{ collection :from="mount" }}
    {{ title }}
{{ /collection}}
```

:::tip
If you are coming from Statamic 2, you might have used the `{{ entries }}` tag pair to loop through mounted collections. That tag is no longer available, and instead, you should use the above approach.
:::


## Search Indexes

You can configure search indexes for your collections to improve the efficiency and relevancy of your users searches. Learn [how to connect indexes](search#connecting-indexes).

## Revisions

Revisions allow you to see the history of any given entry over time. Revisions need to be enabled on the site level ([read those docs](/revisions)), and then you can enable them for any collection.

```
revisions: true
```

## Labels

Throughout the control panel you may find buttons that say "Create Entry".

If you would rather them say something more specific (for example, "Create Article"), you may customize them per-collection by adding a translation key.

In `lang/en/messages.php`, you can add `{handle}_collection_create_entry` with the appropriate label.

```php
<?php
return [
    'articles_collection_create_entry' => 'Create Article',
];
```

Of course, you may add the same key to `messages.php` in other language directories as necessary.

## Localization

When running a [multi-site](/multi-site) installation, you can have entries exist in multiple sites with different content, or have entries exclusive to a site.

[Read about localizing entries](/tips/localizing-entries)
