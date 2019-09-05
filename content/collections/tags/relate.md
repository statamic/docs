---
title: Relate
description: Grab data through relationships.
overview: |
  Relate allows you to fetch content from a relationship using a very simple tag syntax. Relate tags can even be nested inside each other.

  It is designed to work hand in hand with the Relate field.
parameters:
  -
    name: taxonomy
    type: string
    description: |
      When referencing a list of term values, this is the taxonomy that you'd like to pull them from.
      If you have a list of term IDs, this parameter is not necessary. [More details](/taxonomies#without-taxonomizing)
  -
    name: supplement_taxonomies
    type: boolean *true*
    description: >
      By default, Statamic will convert taxonomy term values into actual term objects that you may loop through.
      This has some performance overhead, so you may disable this for a speed boost if taxonomies aren't necessary.
parameters_content: |
  The parameters are inherited from the [collection](/tags/collection) tag. Everything available there is available here.
video: https://youtu.be/TkxvBIGzUr8
id: dd9513b4-4cbb-4481-bf72-eb076e053b04
---

## Example {#example}

Let’s say you have a blog post with a Suggest field called `similar_posts` that you use to set, you guessed it, similar posts. That relationship data is saved as a YAML list of IDs, like so:

``` .language-markdown
---
title: Why Bears are Awesome
similar_posts:
  - 892hnfe983f
  - 980naf80d9a
---
Bears. Beets. Battlestar Galactica.
```

You'd then use the `relate` tag to fetch field data from those entries with a single tag.

```
<ul class="similar-posts">
  {{ relate:similar_posts }}
      <li><a href="{{ url }}">{{ title }}</a></li>
  {{ /relate:similar_posts }}
</ul>
```
