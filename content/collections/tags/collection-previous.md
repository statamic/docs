---
title: Previous
overview: Grab the previous entries relative to current entry in a Collection.
parent_tag: 045a6e54-c792-483a-a109-f07251a79e47
id: 741cf972-c0bd-4e3c-81e2-8cc8bea60737
---
This Tag functions the same way as the [`collection:next`](/tags/collection-next) tag, but in the opposite direction.

```
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
