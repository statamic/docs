---
title: "Nav:Breadcrumbs"
parent_tag: ed746608-87f9-448f-bf57-051da132fef7
intro: >
  Breadcrumbs are a common form of site navigation designed to give the user a view of where the current page is in the parent/child hierarchy. Much like the crumbs left by a certain little German boy — they lead from wherever you are, all the way back home.
description: Display breadcrumb-style navigation links to your current page.
parameters:
  -
    name: include_home
    type: 'boolean'
    description: >
      Include the home page as the first breadcrumb. Default: `true`.
  -
    name: reverse
    type: 'boolean'
    description: Reverse the order of links.
  -
    name: trim
    type: 'boolean *true*'
    description: >
      Trim the whitespace from each iteration
      of the loop. Default: `true`.
variables:
  -
    name: is_current
    type: boolean
    description: >
      `true` if current page is the URL being viewed. Useful for adding
      active state classes in your HTML.
  -
    name: data/content
    type: mixed
    description: >
      All data and variables are available for each item in the list.
id: 485f1703-fc6f-4d0f-94f2-e84ae625e1b7
---
## Overview

This tag looks at the current URL and look for any entries that match each segment. Let's say you visit `/italian/articles/dance`. The logic works like this:

1. Looks for an entry with a URL of /italian/articles/dance.
2. Pops the last segment off (`dance`) and look for an entry with a url of `/italian/articles`
3. Do the same for `/italian`
4. If `include_home` is set to `true`, look an entry with a url of `/`.

If any of the URLs don't match an entry in the current site, they will be skipped, so be sure to create translations for parent pages you if you're working on a multisite.

:::tip
Breadcrumbs don't follow structures, they follow the current URL hierarchy.
:::

## Example

Here's an example of what breadcrumbs might look like, as well as a code example in use.

<figure>
    <div class="flex font-mono space-x-4 mx-4">
      <div>Home</div>
      <div>&rarr;</div>
      <div>Blog</div>
      <div>&rarr;</div>
      <div class="text-pink-hot font-bold">How to Dress Like David Hasselhoff</div>
    </div>
    <figcaption>These crumbs are delicious.</figcaption>
</figure>

```
<ul class="breadcrumbs">
    {{ nav:breadcrumbs }}
    <li{{ if is_current }} class="current"{{ /if }}>
        <a href="{{ url }}">{{ title }}</a>
    </li>
    {{ /nav:breadcrumbs }}
</ul>
```
