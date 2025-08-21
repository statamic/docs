---
id: 045a6e54-c792-483a-a109-f07251a79e47
blueprint: tag
title: Collection
is_parent_tag: true
intro: 'Entries are grouped into Collections and are fetched and filtered by this tag. A Collection could contain blog posts, products, or even a bag full of dad jokes. We don''t judge, and neither does the Collection Tag.'
description: 'Fetches and filters entries in one or more collections.'
stage: 1
parameters:
  -
    name: from|folder|use
    type: string|array
    description: 'The name of the collection(s). Pipe separate names to fetch entries from multiple collections. You may use `*` to get entries from all collections.'
    required: false
  -
    name: not_from|not_folder|dont_use
    type: string|array
    description: 'When getting all collections with `*`, this parameter can accept a pipe delimited list of collections to exclude.'
    required: false
  -
    name: collection
    type: 'tag part'
    description: 'The name of the collection when using the shorthand syntax. This is not actually a parameter, but part of the tag itself. For example, `{{ collection:blog }}`.'
    required: false
  -
    name: show_future
    type: 'boolean *false*'
    description: 'Date-based entries from the future are excluded from results by default. Of course, if you want to show upcoming events or similar content, flip this switch.'
    required: false
  -
    name: show_past
    type: 'boolean *true*'
    description: 'Just like `show_future`, but for entries in the past.'
    required: false
  -
    name: since
    type: string/var
    description: 'Limits the date the earliest point in time from which date-based entries should be fetched. You can use plain English (PHP''s `strtotime` method will interpret. eg. `last sunday`, `january 15th, 2013`, `yesterday`) or the name any date variable.'
    required: false
  -
    name: until
    type: string/var
    description: 'The inverse of `since`, but sets the _max_ date.'
    required: false
  -
    name: sort
    type: string
    description: 'Sort entries by field name (or `random`). You may pipe-separate multiple fields for sub-sorting and specify sort direction of each field using a colon. For example, `sort="title"` or `sort="date:asc|title:desc"` to sort by date then by title. To sort manually, use `sort="order"`. (Make sure to set max depth to 1 for your collection).'
    required: false
  -
    name: limit
    type: integer
    description: 'Limit the total results returned.'
    required: false
  -
    name: filter|query_scope
    type: string
    description: "Apply a custom [query scope](/extending/query-scopes-and-filters) You should specify the query scope's handle, which is usually the name of the class in snake case. For example: `MyAwesomeScope` would be `my_awesome_scope`."
    required: false
  -
    name: offset
    type: integer
    description: 'Skip a specified number of results.'
    required: false
  -
    name: taxonomy
    type: mixed
    description: 'A multitude of ways to filter by taxonomies. [More details](#taxonomies)'
    required: false
  -
    name: paginate
    type: 'boolean|int *false*'
    description: 'Specify whether your entries should be paginated. You can pass `true` and also use the `limit` param, or just pass the limit directly in here.'
    required: false
  -
    name: page_name
    type: 'string *page*'
    description: 'The query string variable used to store the page number (ie. `?page=`).'
    required: false
  -
    name: on_each_side
    type: 'int *3*'
    description: When using pagination, this specifies the max number of links each side of the current page. The minimum value is `1`.
  -
    name: as
    type: string
    description: 'Alias your entries into a new variable loop.'
    required: false
  -
    name: scope
    type: string
    description: 'Scope your entries with a variable prefix.'
    required: false
  -
    name: locale|site
    type: string
    description: 'Show the retrieved content in the selected locale.'
    required: false
  -
    name: redirects|links
    type: 'boolean *false*'
    description: 'By default, entries with redirects will be filtered out. Set this to `true` to include them.'
    required: false
variables:
  -
    name: first
    type: boolean
    description: 'Is this the first item in the loop?'
  -
    name: last
    type: boolean
    description: 'Is this the last item in the loop?'
  -
    name: count
    type: integer
    description: 'The number/index of current iteration in the loop, starting from 1'
  -
    name: index
    type: integer
    description: 'The number/index of current iteration in the loop, starting from 0'
  -
    name: order
    type: integer
    description: 'The number/index of the item relative to the collection, not affected by any sort/filter parameters on the tag. Note: this is only available on collections where the order is set to number.'
  -
    name: no_results
    type: boolean
    description: 'Returns true if there are no results.'
  -
    name: total_results
    type: integer
    description: 'The total number of results in the loop when there are results. You should use `no_results` to check if any results exist.'
  -
    name: 'entry data'
    type: mixed
    description: 'Each result has access to all the variables inside that entry (`title`, `content`, etc).'
related_entries:
  - 7202c698-942a-4dc0-b006-b982784efb03
  - 8ed04215-9f46-4000-bd67-c71b21b67d85
  - 6177b316-0eed-4dec-83d1-e5a48a8e00b6
  - 3c34ef5c-781e-4a22-a09b-25f58bdb58a8
  - 74c47654-8c47-49b1-a616-ed940ce19977
---
## Overview

The collection tag is one of main workhorses of your Statamic [frontend](/frontend). It's like an Eloquent model in Laravel or "The Loop" in WordPress – it's how you get data from everywhere (_other than_ the current entry and global variables) into your [view](/views).

## Example

A basic example would be to loop through the entries in a blog collection and link to each individual blog post:

::tabs
::tab antlers
```antlers
<ul>
{{ collection from="blog" }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /collection }}
</ul>
```
::tab blade
```blade
<ul>
<statamic:collection
    from="blog"
>
    <li><a href="{{ $url }}">{{ $title }}</a></li>
</statamic:collection>
</ul>
```
::

You can also use the shorthand syntax for this. We prefer this style ourselves.

::tabs
::tab antlers
```antlers
<ul>
{{ collection:blog }}
    <li><a href="{{ url }}">{{ title }}</a></li>
{{ /collection:blog }}
</ul>
```

::tab blade
```blade
<ul>
<statamic:collection:blog>
    <li><a href="{{ $url }}">{{ $title }}</a></li>
</statamic:collection:blog>
</ul>
```
::

If you'd like to fetch entries from multiple collections, you'll need to use the standard syntax.

::tabs
::tab antlers
```antlers
{{ collection from="blog|events" }}
```
::tab blade
```blade
<statamic:collection
    from="blog|events"
>

</statamic:collection>
```
::

To get entries from _all_ collections, use the wildcard `*`. You may also exclude collections when doing this.

::tabs
::tab antlers
```antlers
{{ collection from="*" not_from="blog|events" }}
```
::tab blade
```blade
<statamic:collection
    from="*"
    not_from="blog|events"
>

</statamic:collection>
```
::

## Filtering

There are a number of ways to filter your collection. There's the conditions syntax for filtering by fields, taxonomy filter for using terms, and the custom filter class if you need extra control.

### Conditions

Want to get entries where the title has the words "awesome" and "thing", and "joe" is the author? You can write it how you'd say it:

::tabs
::tab antlers
```antlers
{{ collection:blog title:contains="awesome" title:contains="thing" author:is="joe" }}
```

::tab blade

```blade
<statamic:collection:blog
    title:contains="awesome"
    title:contains="thing"
    author:is="joe"
>

</statamic:collection:blog>
```
::

There are a bunch of conditions available to you, like `:is`, `:isnt`, `:contains`, `:starts_with`, and `:is_before`. There are many more than that. In fact, there's a whole page dedicated to [conditions - check them out][conditions].

### Taxonomies

Filtering by a taxonomy term (or terms) is done using the `taxonomy` parameter, similar to the conditions syntax mentioned above.

To show entries with the `harry-potter` term within the `tags` taxonomy, you could do this:

::tabs
::tab antlers
```antlers
{{ collection:blog taxonomy:tags="harry-potter" }}
```

::tab blade

```blade
<statamic:collection:blog
    taxonomy:tags="harry-potter"
>

</statamic:collection:blog>
```
::

It is important that the collection has been [configured to use this taxonomy](/collections#taxonomies) in order to filter the results based on the passed in term.

:::tip
There are several different ways to use this filtering parameter. They are explained in depth on the [Conditions page](/conditions#taxonomy-conditions).
:::

### Published Status

By default, only `published` entries are included.  Entries can be queried against `any`, `draft`, `scheduled`, or `expired` status with [conditions](#conditions) on `status` like this:

::tabs
::tab antlers
```antlers
// Only include published entries
{{ collection:blog status:is="published" }}
```

::tab blade

```blade
<statamic:collection:blog
    status:is="published"
>

</statamic:collection:blog>
```
::

:::tip
**What is the difference between filtering against `published` and `status`?** Read more on [date behavior and published status](/collections#date-behavior-and-published-status)!
:::


### Custom Query Scopes

Doing something custom or complicated? You can create [query scopes](/extending/query-scopes-and-filters) to narrow down those results with the `query_scope` or `filter` parameter:

::tabs
::tab antlers
```antlers
{{ collection:blog query_scope="your_query_scope" }}
```

::tab blade
```blade
<statamic:collection:blog
    query_scope="your_query_scope"
>

</statamic:collection:blog>
```
::

You should reference the query scope by its handle, which is usually the name of the class in snake case. For example: `YourQueryScope` would be `your_query_scope`.

## Pagination

To enable pagination mode, add the `paginate` parameter with the number of entries in each page.

::tabs

::tab antlers
```antlers
{{ collection:blog paginate="10" as="posts" }}

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
::tab blade
```blade
<statamic:collection:pages
  paginate="10"
  as="posts"
>
  @if ($no_results)
    <p>Aww, there are no results.</p>
  @endif

  @foreach ($posts as $post)
    <article>
      {{ $post->title }}
    </article>
  @endforeach

  @if ($paginate['total_pages'] > 1)
    <a href="{{ $paginate['prev_page'] }}">⬅ Previous</a>

    {{ $paginate['current_page'] }} of {{ $paginate['total_pages'] }} pages
    (There are {{ $paginate['total_items'] }} posts)

    <a href="{{ $paginate['next_page'] }}">Next ➡</a>
  @endif
</statamic:collection:pages>
```
::

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

::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<statamic:collection:blog
  paginate="10"
  as="posts"
>
  @if ($no_results)
    <p>Aww, there are no results.</p>
  @endif

  @foreach ($posts as $post)
    <article>
      {{ $post->title }}
    </article>
  @endforeach

  @if ($paginate['total_pages'] > 1)
    @php
        $hasSlider = count($paginate['links']['segments']['slider']) > 0;
        $hasLast = count($paginate['links']['segments']['last']) > 0;
    @endphp

    <ul class="pagination">
      @if ($paginate['prev_page'])
        <li><a href="{{ $paginate['prev_page'] }}">&laquo;</a></li>
      @else
        <li class="disabled"><span>&laquo;</span></li>
      @endif

      @foreach (Arr::get($paginate, 'links.segments.first', []) as $segment)
        @if ($segment['page'] == $paginate['current_page'])
          <li class="active"><span>{{ $segment['page'] }}</span></li>
        @else
          <li><a href="{{ $segment['url'] }}">{{ $segment['page'] }}</a></li>
        @endif
      @endforeach

      @if ($hasSlider)
        <li class="disabled"><span>...</span></li>
      @endif

      @foreach (Arr::get($paginate, 'links.segments.slider', []) as $segment)
        @if ($segment['page'] == $paginate['current_page'])
          <li class="active"><span>{{ $segment['page'] }}</span></li>
        @else
          <li><a href="{{ $segment['url'] }}">{{ $segment['page'] }}</a></li>
        @endif
      @endforeach

      @if ($hasSlider || $hasLast)
        <li class="disabled"><span>...</span></li>
      @endif

      @foreach (Arr::get($paginate, 'links.segments.last', []) as $segment)
        @if ($segment['page'] == $paginate['current_page'])
          <li class="active"><span>{{ $segment['page'] }}</span></li>
        @else
          <li><a href="{{ $segment['url'] }}">{{ $segment['page'] }}</a></li>
        @endif
      @endforeach

      @if ($paginate['next_page'])
        <li><a href="{{ $paginate['next_page'] }}">&raquo;</a></li>
      @else
        <li class="disabled"><span>&raquo;</span></li>
      @endif
    </ul>
  @endif
</statamic:collection:blog>
```
::

## Aliasing {#alias}

Often times you'd like to have some extra markup around your list of entries, but only if there are results. Like a `<ul>` element, for example. You can do this by _aliasing_ the results into a new variable tag pair. This actually creates a copy of your data as a new variable. It goes like this:

::tabs
::tab antlers
```antlers
{{ collection:blog as="posts" }}
    <ul>
      {{ posts }}
        <li>
            <a href="{{ url }}">{{ title }}</a>
        </li>
      {{ /posts }}
    <ul>
{{ /collection:blog }}
```
::tab blade
```blade
<statamic:collection:blog
  as="posts"
>
  <ul>
    @foreach ($posts as $post)
    <li>
      <a href="{{ $post->url }}">{{ $post->title }}</a>
    </li>
    @endforeach
  </ul>
</statamic:collection:blog>
```
::

## Scoping {#scope}

Sometimes not all of your entries have the same set of variables. And sometimes the page that you're on (while listing entries in a Collection, for example) may have those very same variables on the page-level scope. Statamic assumes you'd like to fallback to the parent scope's data to plug any holes. This logic has pros and cons, and you can [read more about scoping and the Cascade here](/cascade).

You can assign a _scope_ prefix to your entries so you can be sure to get the data you want. Define your scope and then prefix all of your variables with it.

```yaml
# Page data
featured_image: /img/totes-adorbs-kitteh.jpg
```

::tabs
::tab antlers
```antlers
{{ collection:blog scope="post" }}
  <div class="block">
    <img src="{{ post:featured_image }}">
  </div>
{{ /collection:blog }}
```

::tab blade
```blade
<statamic:collection:blog
    scope="post"
>
  <div class="block">
    <img src="{{ $post->featured_image }}">
  </div>
</statamic:collection:blog>
```
::

You can also add your scope down into your [alias](#alias) loop. Yep, we thought of that too.

::tabs
::tab antlers
```antlers
{{ collection:blog as="posts" }}
  {{ posts scope="post" }}
    <div class="block">
      <img src="{{ post:featured_image }}">
    </div>
  {{ /posts }}
{{ /collection:blog }}
```
::tab blade
```blade
<statamic:collection:blog
    as="posts"
>
  @foreach ($posts as $post)
    <div class="block">
      <img src="{{ $post->featured_image }}">
    </div>
  @endforeach
</statamic:collection:blog>
```
::

Combining both an Alias and a Scope on a Collection Tag doesn't make a whole lot of sense. You shouldn't do that.

## Grouping

To group entries – by date or any other field – you should use [aliasing](#alias) (explained above) as well as the [`group_by`](/modifiers/group_by) modifier.
There's no "grouping" feature on the collection tag itself.

For example, if you want to group some dated entries by month/year, you could do this:

::tabs

::tab antlers
```antlers
{{ collection:articles as="entries" }}
    {{ entries group_by="date|F Y" }}
        {{ groups }}
            <h3>{{ group }}</h3>
            {{ items }}
                {{ title }} <br>
            {{ /items }}
        {{ /groups }}
    {{ /entries }}
{{ /collection:articles }}
```
::tab blade
```blade
<statamic:collection:articles
  as="entries"
>
  @php
  $groupedEntries = $entries->groupBy(fn($entry) => $entry->date?->format('F Y'));
  @endphp

  @foreach ($groupedEntries as $group => $items)
    <h3>{{ $group }}</h3>

    @foreach ($items as $entry)
      {{ $entry->title }}
    @endforeach
  @endforeach
</statamic:collection:articles>
```
::

[conditions]: /conditions
