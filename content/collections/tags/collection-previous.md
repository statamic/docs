---
title: "Collection:Previous"
description:  Fetches the previous entries in order.
intro: If you're on a single entry page and want to show _previous_ entries in order (publish date, alphabetical, or manual), this is the tag you're looking for.
parent_tag: 045a6e54-c792-483a-a109-f07251a79e47
parameters:
  -
    name: in|collection
    type: string
    description: >
      Explicitly define a collection. Defaults to whatever collection the current entry is in.
  -
    name: current
    type: 'string'
    description: >
      Explicitly define a current entry by `id`. Defaults to the current entry in context.
  -
    name: collection params
    type: inheritance
    description: 'All [collection tag](/tags/collection#parameters) parameters are available.'
variables:
  -
    name: no_results
    type: boolean
    description: >
      `true` if no results.
id: 741cf972-c0bd-4e3c-81e2-8cc8bea60737
---
## Date Order
This tag relies on the native publish `date` field for date ordering.

## Example

This will show the next 2 posts in a `blog` collection. It'll scope the entries loop into the `posts` tag pair. If there are no more entries, the no results text will be shown.

::tabs

::tab antlers
```antlers
{{ collection:previous in="blog" as="posts" limit="2" sort="date:asc" }}

  {{ if no_results }}
    No more posts to read!
  {{ /if }}

  {{ posts }}
    <div class="post">
      <a href="{{ url }}">{{ title }}</a>
    </div>
  {{ /posts }}

{{ /collection:previous }}
```
::tab blade
```blade
<statamic:collection:previous
  in="blog"
  as="posts"
  limit="2"
  sort="date:asc"
>
  @if ($no_results)
    No more posts to read!
  @endif

  @foreach ($posts as $post)
    <div class="post">
      <a href="{{ $post->url }}">{{ $post->title }}</a>
    </div>
  @endforeach
</statamic:collection:previous>
```
::

:::tip
This functions the same way as the [collection:next](/tags/collection-next) tag but in the opposite direction.
:::
