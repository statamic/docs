---
title: 'Collections'
intro: Collections are containers that hold groups of related entries. Each entry in a collection might represent a blog post, product, recipe, or even chapter of your Family Matters fan fiction novel following Steve Urkel's rise to UFC Heavyweight Champion.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568644358
blueprint: page
stage: 4
id: 7202c698-942a-4dc0-b006-b982784efb03
---
## Entries

Each entry has — at the very least — a title, a published status, an id, and some content. The content fields are determined by one or more [blueprints](/blueprints) set on the collection. By default they're stored as Markdown files inside their collection's respective directory (`content/collections/{collection}/entry.md`).

Let's pretend it's currently the summer of '99 and we are journalists covering the X-Games. Here's an entry we might write.

<figure>
    <img src="/img/entry-tony-hawk.png" alt="An entry being edited in the Statamic 3 control panel">
    <figcaption>Entry publishing with only the default content fields.</figcaption>
</figure>

And here's what the Markdown file would look like for that same entry.

``` markdown
<!-- content/collections/blog/1999-07-27.tony-hawks-900.md -->
---
title: Tony Hawk lands the first-ever 900
published: true
id: 3a28f050-f8d2-4a56-ba8a-314a9d46bf38
---
It took skateboarding legend Tony Hawk 11 tries, but he finally landed a 900 at the 1999 Summer X Games in a moment that launched the sport into popular consciousness in a new way.
```

You can create, edit, and delete entries in the control panel _or_ filesystem, it's up to you and your preference in the heat of moment. Let your passion carry you away.

### Data Cascade

Each entry has its own unique URL. When you're on it, all of the entry's data will be available in your views as variables. If an entry is _missing_ data, intentionally or not, it will fall back to a series of defaults. We call this fallback logic [the cascade](/cascade).

1. The entry
2. The origin entry (if using localization)
3. The collection

If a value doesn't exist in one place, it'll check the next place, then the next, and so on.

### Default collection data {#inject}

Injecting data into your collection allows you to provide default values for your entries with the `inject` variable. If entries have these variables set, they will override the collection defaults.

``` yaml
inject:
  author: jason
  show_sidebar: true
```

## Collections

Collections are the containers that hold entries. You can think of them like shoeboxes containing love letters, except they're folders on your server and they're holding text documents. So, not exactly the same thing, or at least not as romantic anyway.

The collection holds settings that affect all of the entries. It's also responsible for the URL patterns by way of [routes](/routing), which fields are available with [blueprints](/blueprints), as well as any desired [date behaviors](#dates).

You can also set default values for all entries, including default template, blueprint, and publish status.

A collection is defined by a YAML file stored in the `content/collections` directory. All accompanying entries will be stored in a sub-directory with a matching name. For example, a `blog` collection looks like this:

``` files
├── content/collections/
│   ├── blog.yaml
│   ├── blog/
│   │   ├── hello.md
│   │   ├── is-it-me.md
│   │   ├── youre-looking-for.md
```

## Blueprints

Each Collection uses blueprints to define the available fields when creating and editing its entries.

If you don't explicitly create a blueprint, your entries will have a basic set of fields: title, markdown content, slug, etc. Of course, you're able to create your own.

If you create _more than_ one blueprint you'll be given the option to choose which one you want when creating a new entry.

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

> Date behaviors are _defaults_. They can be overridden on the tag level.

## Times

To get more granular and introduce _time_, add a [date field](/fieldtypes/date) named `date` to your blueprint and Statamic will repsect however you configure it. You can use this approach to have entries publish at a **specific times**, e.g. `11:45am`.

## Ordering

Flick on the "Orderable" switch in a collection's settings and you'll have a drag and drop UI in the control panel to order the entries. The collection is now "structured". Learn more about [structures](/structures).


<figure>
    <img src="/img/collection-structure.png" alt="An orderable collection">
    <figcaption>You can tell these entries are orderable because of the way they are.</figcaption>
</figure>

> Order will take precedence when sorting. For example, if you make a dated collection **orderable**, date will no longer be the default sort order. You still can sort by date by specifying `sort="date"` on your [collection tag](/tags/collection).

### Constraining Depth

A structured collection will **not** have a maximum depth by default, allowing you to nest entries as deep as you like. Set the `max_depth` option to limit this behavior. Setting `max_depth: 1` will replace the page tree UI with a flat, table-based UI.

<figure>
    <img src="/img/reorderable-entries.png" alt="An orderable collection with max depth of 1">
    <figcaption>These reorderable entries have a max depth of 1.</figcaption>
</figure>

### Default sort order in listings

For non-structured collections, you can choose which field and direction to sort the list of entries in the Control Panel by setting the `sort_by` and `sort_dir` variables in your collection.yaml. By default the Title field will be used.

## Routing

Entries receive their URLs from their collection's route setting. You can use standard meta variables in addition to the variables from the collection's blueprint to define your route rule.

``` yaml
route: /blog/{slug}
```

If you are building a multi-site and want different routes for different locales:

```yaml
route:
  english: /events/{slug}
  french: /evenements/{slug}
```

> When creating new collections, Statamic doesn't automatically define a default route rule. If you want entries in your new collection to receive URLs, make sure you define a route rule!

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

### Example routes

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
``` yaml
route: /tournament/round-{depth}/{team}
# example: /tournament/round-4/chicago-bulls
```

#### Organizing gaming articles

You can even use Antlers to get more complicated. Here we'll include the [mounted](#mounting) entry at the top level.

``` yaml
mount: 'id-of-games-page'
route: '{{ depth == 1 ?= mount }}/{{ parent_uri }}/{{ slug }}'
# example: /games/zork/how-to-play/controls
```

> If you're using Antlers in your route, you need to stick with the `{{ double curlies }}` syntax.

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

Any other strings will be assumed to be a relative link. (eg. if the page URL is `/my/page` and you have `redirect: is/here`, you will be redirected to `/my/page/is/here`)

> Entries with redirects will get filtered out of the [collection](/tags/collection) tag by default. You can include them by adding a `redirects="true"` parameter.

### Entry Link Blueprint

When a Collection is structured, you will be presented with the option to create "Links" along with any other available blueprints when you try to create an entry.

This will load a behind-the-scenes blueprint containing `title` and `redirect` fields. You are free to modify what's shown on these pages by creating your own `entry_link` blueprint.

## Taxonomies

In Statamic 3, [taxonomies](/taxonomies) are defined on the _collection level_, not the blueprint-level. This enforces a tighter content-model, and reduces complexity when configuring blueprints.

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

You can mount a collection to an entry by specifying the ID of said entry. You can also use the `mount` variable in the route to prepend the mounted entry's URL.

So for example, if you mounted a collection to `/blog` with `/{mount}/{slug}`, all your blog URLs will follow the `/blog/entry-url` pattern. If you later move `/blog` to `/articles`, all your entries will follow along with `/articles/entry-url`.

``` yaml
title: Blog
mount: id-of-the-blog-entry
route: '{mount}/{slug}'
```

## Revisions

Revisions allow you to see the history of any given entry over time. Revisions need to be enabled on the site level ([read those docs](/revisions)), and then you can enable them for any collection.

```
revisions: true
```

## Labels

Throughout the control panel you may find buttons that say "Create Entry".

If you would rather them say something more specific (for example, "Create Article"), you may customize them per-collection by adding a translation key.

In `resources/lang/en/messages.php`, you can add `{handle}_collection_create_entry` with the appropriate label.

```php
<?php
return [
    'articles_collection_create_entry' => 'Create Article',
];
```

Of course, you may add the same key to `messages.php` in other language directories as necessary.

## Localization

When running a [multi-site](/multi-site) installation, you can have entries exist in multiple sites with different content, or have entries exclusive to a site.

[Read about localizing entries](/knowledge-base/localizing-entries)
