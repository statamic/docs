---
title: "Nav:Breadcrumbs"
parent_tag: ed746608-87f9-448f-bf57-051da132fef7
overview: >
  Breadcrumbs are a common form of site navigation designed to give the user hierarchal context. Much like the crumbs left by a little German boy named Hansel (so 🔥 right now), they lead from where you are, all the way back home.
description: Display breadcrumb-style navigation links to your current page.
parameters:
  -
    name: 'url'
    type: string
    description: >
      Defaults to your current page, but can be set to anywhere if necessary.
  -
    name: include_home
    type: 'boolean *TRUE*'
    description: >
      You can choose to turn off the home page
      in the breadcrumbs, opting to start the
      crumbs from the first level nav item.
  -
    name: reverse
    type: 'boolean *TRUE*'
    description: Reverse the output of the breadcrumbs.
  -
    name: trim
    type: 'boolean *TRUE*'
    description: >
      Trim the whitespace from each iteration
      of the loop.
variables:
  -
    name: is_current
    type: boolean
    description: >
      Whether the current page is the URL
      being viewed. Useful for outputting
      active states.
  -
    name: page data
    type: mixed
    description: >
      Each page being iterated has access to
      all the variables inside that page. This
      includes things like `title`, `content`,
      etc.
id: 485f1703-fc6f-4d0f-94f2-e84ae625e1b7
---
## Example

Here's an example of what breadcrumbs might look like, as well as a code example in use.

![img](/assets/img/other/breadcrumbs.png) {width=450}

``` php
<ul class="breadcrumbs">
    {{ nav:breadcrumbs }}
    <li{{ if is_current }} class="current"{{ /if }}>
        <a href="{{ url }}">{{ title }}</a>
    </li>
    {{ /nav:breadcrumbs }}
</ul>
```
