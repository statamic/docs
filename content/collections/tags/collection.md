---
title: Collection
is_parent_tag: true
intro: Entries are grouped into Collections and are fetched and filtered by this tag. A Collection could contain blog posts, products, or even a bag full of dad jokes. We don't judge and neither does the Collection Tag.
description: Grab and filter the entries in a specified Collection.
stage: 1
parameters:
  -
    name: from|folder|use
    type: string|array
    description: 'The name of the collection(s). Pipe separate names to fetch entries from multiple collections. You may use `*` to get entries from all collections.'
  -
    name: not_from|not_folder|dont_use
    type: string|array
    description: 'When getting all collections with `*`, this parameter can accept a pipe delimited list of collections to exclude.'
  -
    name: collection
    type: tag part
    description: 'The name of the collection when using the shorthand syntax. This is not actually a parameter, but part of the tag itself. For example, `{{ collection:blog }}`.'
  -
    name: show_unpublished
    type: 'boolean *false*'
    description: "Unpublished content is, by it's very nature, unpublished. That is, unless you show it by turning on this parameter."
  -
    name: show_published
    type: 'boolean *true*'
    description: 'Setting this to `false` will prevent published entries from being displayed. Pairs nicely with `show_unpublished="true"` to only show drafts.'
  -
    name: show_future
    type: 'boolean *false*'
    description: >
      Date-based entries from the future are
      excluded from results by default. Of
      course, if you want to show upcoming
      events or similar content, flip this
      switch.
  -
    name: show_past
    type: 'boolean *true*'
    description: >
      Just like `show_future`, but for entries
      in the past.
  -
    name: since
    type: string/var
    description: "Limits the date the earliest point in time from which date-based entries should be fetched. You can use plain English (PHP's `strtotime` method will interpret. eg. `last sunday`, `january 15th, 2013`, `yesterday`) or the name any date variable."
  -
    name: until
    type: string/var
    description: >
      The inverse of `since`, but sets the _max_
      date.
  -
    name: sort
    type: string
    description: >
      Sort entries by field name (or `random`). You may pipe-separate multiple fields for sub-sorting and specify sort direction of each field using a colon.
      For example, `sort="title"` or `sort="date:asc|title:desc"` to sort by date then by title.
      To sort numerically, use `sort="order"`. (Make sure to include `order: number` in your collection's folder.yaml file).
  -
    name: limit
    type: integer
    description: Limit the total results returned.
  -
    name: offset
    type: integer
    description: The number of entries the results should by offset by.
  -
    name: taxonomy
    type: mixed
    description: >
      A multitude of ways to filter by taxonomies. [More details](#taxonomies)
  -
    name: group_by_date
    type: string
    description: >
      Group entries by date. [Read more](#grouping-by-date)
  -
    name: paginate
    type: 'boolean *false*'
    description: >
      Specify whether your entries should be paginated.
  -
    name: as
    type: string
    description: >
      Alias your entries into a new variable loop.
  -
    name: scope
    type: string
    description: >
      Scope your entries with a variable prefix.
  -
    name: locale
    type: string
    description: Show the retrieved content in the selected locale.
variables:
  -
    name: first
    type: boolean
    description: Is this the first item in the loop?
  -
    name: last
    type: boolean
    description: Is this the last item in the loop?
  -
    name: index
    type: integer
    description: >
      The number/index of current iteration in the loop, starting from 1
  -
    name: zero_index
    type: integer
    description: >
      The number/index of current iteration in the loop, starting from 0
  -
    name: order
    type: integer
    description: >
      The number/index of the item relative to the collection, not affected by any sort/filter parameters on the tag. Note: this is only available on collections where the order is set to number.
  -
    name: no_results
    type: boolean
    description: Returns true if there are no results.
  -
    name: total_results
    type: integer
    description: The total number of results in the loop when there are results. You should use `no_results` to check if any results exist.
  -
    name: entry data
    type: mixed
    description: >
      Each result has access to all the variables inside that entry (`title`, `content`, etc).
id: 045a6e54-c792-483a-a109-f07251a79e47
---
## Overview

The collection tag is one of main workhorses of your Statamic [frontend](/frontend). It's like an Eloquent model in Laravel or "The Loop" in WordPress – it's how you get data from everywhere (_other than_ the current entry and global variables) into your [view](/views).

## Example

A basic example would be to loop through the entries in a blog collection and link to each individual blog post:

```
<ul>
{{ collection from="blog" }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /collection }}
</ul>
```

You can also use the shorthand syntax for this. We prefer this style ourselves.

```
<ul>
{{ collection:blog }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /collection:blog }}
</ul>
```

If you'd like to fetch entries from multiple collections, you'll need to use the standard syntax.

```
{{ collection from="blog|events" }}
```

To get entries from _all_ collections, use the wildcard `*`. You may also exclude collections when doing this.

```
{{ collection from="*" not_from="blog|events" }}
```

## Filtering

There are a number of ways to filter your collection. There's the conditions syntax for filtering by fields, taxonomy filter for using terms, and the custom filter class if you need extra control.

### Conditions

Want to get entries where the title has the words "awesome" and "thing", and "joe" is the author? You can write it how you'd say it:

```
{{ collection:blog
   title:contains="awesome"
   title:contains="thing"
   author:is="joe"
}}
```

There are a bunch of conditions available to you, like `:is`, `:isnt`, `:contains`, `:starts_with`, and `:is_before`. There are many more than that. In fact, there's a whole page dedicated to [conditions - check them out][conditions].

### Taxonomies

Filtering by a taxonomy term (or terms) is done using the `taxonomy` parameter, similar to the conditions syntax mentioned above.

To show entries with the `harry-potter` term within the `tags` taxonomy, you could do this:

```
{{ collection:blog taxonomy:tags="harry-potter" }}
```

There are a number of different ways to use this parameter. They are explained in depth in the
[Taxonomies Guide](/taxonomies#collections)


### Custom Query Scopes

Doing something custom or complicated? You can create [query scopes](/extending/query-scopes-and-filters) to narrow down those results.

## Pagination

To enable pagination mode, add the `paginate="true"` parameter, along with the `limit` parameter to specify the number of entries in each page.

```
{{ collection:blog limit="10" paginate="true" as="posts" }}

    {{ if no_results }}
        <p>Aww, there are no results.</p>
    {{ /if }}

    {{ posts }}
        <article>
            {{ title }}
        </article>
    {{ /posts }}

    {{ paginate }}
        <a href="{{ prev_page }}">⬅ Previous</a>

        {{ current_page }} of {{ total_pages }} pages
        (There are {{ total_items }} posts)

        <a href="{{ next_page }}">Next ➡</a>
    {{ /paginate }}

{{ /collection:blog }}
```

In pagination mode, your entries will be scoped (in the example, we're scoping them into the `posts` tag pair). Use that tag pair to loop over the entries in that page.

The `paginate` variable will become available to you. This is an array containing data about the paginated set.

| Variable | Description |
|----------|-------------|
| `next_page` |	The URL to the next paginated page.
| `prev_page` |	The URL to the previous paginated page.
| `total_items` |	The total number of entries.
| `total_pages` |	The number of paginated pages.
| `current_page` |	The current paginated page. (ie. the x in the ?page=x param)
| `auto_links` |	Outputs an HTML list of paginated links.
| `links` |	Contains data for you to construct a custom list of links.
| `links:all` |	An array of all the pages. You can loop over this and output {{ url }} and {{ page }}.
| `links:segments` |	An array of data for you to create a segmented list of links.

<br>

### Pagination Examples

The `auto_links` tag is designed to be your friend. It'll save you more than a few keystrokes, and even more headaches. It will output an HTML list of links for you. With a large number of pages, it will create segments so that you don't end up with hundreds of numbers.

It's clever enough to work out a comfortable range of numbers to display, and it'll also throw in the prev/next arrow for good measure.

Maybe the default markup isn't for you and you want total control. You're a maverick. That's cool, we roll that way sometimes too. That's where the `links:all` or `links:segments` array variables come in. These give you all the data you need to recreate your own set of links.

- The `links:all` array is _all_ the pages with `url` and `page` variables.

- The `links:segments` array will contain the segments mentioned above. You'll be able to access `first`, `slider`, and `last`, which are the 3 segments.

Here's the `auto_links` output, recreated using the other tags, for you mavericks out there:

```
{{ paginate }}
    <ul class="pagination">
        {{ if prev_page }}
            <li><a href="{{ prev_page }}">&laquo;</a></li>
        {{ else }}
            <li class="disabled"><span>&laquo;</span></li>
        {{ /if }}

        {{ links:segments }}

            {{ first }}
                {{ if page == current_page }}
                    <li class="active"><span>{{ page }}</span></li>
                {{ else }}
                    <li><a href="{{ url }}">{{ page }}</a></li>
                {{ /if }}
            {{ /first }}

            {{ if slider }}
                <li class="disabled"><span>...</span></li>
            {{ /if }}

            {{ slider }}
                {{ if page == current_page }}
                    <li class="active"><span>{{ page }}</span></li>
                {{ else }}
                    <li><a href="{{ url }}">{{ page }}</a></li>
                {{ /if }}
            {{ /slider }}

            {{ if slider || (!slider && last) }}
                <li class="disabled"><span>...</span></li>
            {{ /if }}

            {{ last }}
                {{ if page == current_page }}
                    <li class="active"><span>{{ page }}</span></li>
                {{ else }}
                    <li><a href="{{ url }}">{{ page }}</a></li>
                {{ /if }}
            {{ /last }}

        {{ /links:segments }}

        {{ if next_page }}
            <li><a href="{{ next_page }}">&raquo;</a></li>
        {{ else }}
            <li class="disabled"><span>&raquo;</span></li>
        {{ /if }}
    </ul>
{{ /paginate }}
```

## Aliasing {#alias}

Often times you'd like to have some extra markup around your list of entries, but only if there are results. Like a `<ul>` element, for example. You can do this by _aliasing_ the results into a new variable tag pair. This actually creates a copy of your data as a new variable. It goes like this:

```
{{ collection:blog as="posts" }}
  <ul>
  {{ posts }}
    <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /posts }}
  </ul>
{{ /collection:blog }}
```

## Scoping {#scope}

Sometimes not all of your entries have the same set of variables. And sometimes the page that you're on (while listing entries in a Collection, for example) may have those very same variables on the page-level scope. Statamic assumes you'd like to fallback to the parent scope's data to plug any holes. This logic has pros and cons, and you can [read more about scoping and the Cascade here](/cascade).

You can assign a _scope_ prefix to your entries so you can be sure to get the data you want. Define your scope and then prefix all of your variables with it.

```{.language-yaml}
# Page data
featured_image: /img/totes-adorbs-kitteh.jpg
```

```
{{ collection:blog scope="post" }}
  <div class="block">
    <img src="{{ post:featured_image }}">
  </div>
{{ /collection:blog }}
```

You can also add your scope down into your [alias](#alias) loop. Yep, we thought of that too.

```
{{ collection:blog as="posts" }}
  {{ posts scope="post" }}
    <div class="block">
      <img src="{{ post:featured_image }}">
    </div>
  {{ /posts }}
{{ /collection:blog }}
```

Combining both an Alias and a Scope on a Collection Tag doesn't make a whole lot of sense. You shouldn't do that.

## Grouping by date {#group_by_date}

You can visually group repeating date-based entries.

When using this parameter, the templating structure you need to use will be a little different from a regular loop.

### Example

Let's assume that the entries in the `blog` collection are date-based.


```
{{ collection:blog group_by_date="M Y" as="entries" }}
    {{ date_groups }}
        <h3>{{ date_group }}</h3>
        <ul>
            {{ entries }}
                <li>{{ title }}</li>
            {{ /entries }}
        </ul>
    {{ /date_groups }}
{{ /collection:blog }}
```

The code above will output something like this:

```
<h3>May 2015</h3>
<ul>
  <li>A post from May</li>
  <li>Another from May</li>
</ul>
<h3>June 2015</h3>
<ul>
  <li>A post from June</li>
</ul>
```

The `{{ date_group }}` variable will be the date formatted by whatever you specified in the `group_by_date` parameter.

The `{{ entries }}{{ /entries }}` tag pair will allow you to iterate over the entries in that date group. The name of this variable is specified by the `as` parameter. For example, if you used `as="posts"`, you'd use a `{{ posts }}{{ /posts }}` tag pair.

### Grouping by a custom date field {#group_by_date-custom-field}

If you'd like to group by an arbitrary date field, you can specify the field name as the second value of the parameter.

```
{{ collection:blog group_by_date="M Y|purchase_date" sort="purchase_date" }}
```

Here we are grouping on the `purchase_date` field. Note that you should also sort by that field, as the default sorting
on date-based entries would still be the entry date.

[conditions]: /conditions

