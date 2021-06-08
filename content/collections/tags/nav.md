---
title: Nav
intro: >
  The nav tags are designed to help your users navigate through your hierarchy of navigations and collections.
description: Creates site navigations.
stage: 3
id: ed746608-87f9-448f-bf57-051da132fef7
is_parent_tag: true
video: https://youtu.be/POgIsLeWGGQ
parameters:
  -
    name: handle
    type: string
    description: 'The navigation or collection to use. Not necessary if you''re using the shorthand tag (e.g. `{{ nav:links }}`)'
  -
    name: from
    type: string
    description: "The starting point for your navigation. If unspecified, it'll start from the top. Note: this parameter is only supported for orderable collections."
  -
    name: show_unpublished
    type: 'boolean *false*'
    description: "Unpublished content is, by it's very nature, unpublished. That is, unless you show it by turning on this parameter."
  -
    name: include_home
    type: 'boolean *false*'
    description: >
      You can choose to turn off the home page in the tree, opting to start the crumbs from the first level nav item. Doesn't do
      anything if you're using the `from` paramter.
variables:
  -
    name: is_published
    type: boolean
    description: Whether or not the page is published.
  -
    name: is_page
    type: boolean
    description: >
      Whether or not the page is in fact a
      page. If you are using the `entries`
      parameter to show entries, a "page" may
      potentially be an entry.
  -
    name: is_entry
    type: boolean
    description: >
      The inverse of `is_page`. Outputs
      whether the "page" is an entry.
  -
    name: has_entries
    type: boolean
    description: >
      Whether the current page has entries
      mounted to it.
  -
    name: children
    type: array
    description: >
      An array of child pages. Use this as a
      tag pair to iterate over any child
      pages.
  -
    name: parent
    type: array
    description: "An array containing the current page's parent. Use this as a tag pair to output variables from the parent's page data."
  -
    name: is_parent
    type: boolean
    description: >
      Whether the current page is a parent of
      the URL being viewed. Useful for
      outputting active states.
  -
    name: is_current
    type: boolean
    description: >
      Whether the current page is the URL
      being viewed. Also useful for outputting
      active states.
  -
    name: is_external
    type: boolean
    description: >
      Whether the current nav URL is an external link . Useful for outputting
      `target=_"blank"` in menu templates.      
  -
    name: depth
    type: integer
    description: The depth of the page within the nav structure.
  -
    name: page data
    type: mixed
    description: >
      Each page being iterated has access to
      all the variables inside that page. This
      includes things like `title`, `content`,
      etc.
  -
    name: '*recursive children*'
    type: wizardry
    description: >
      Recursively output the entire contents
      of the `nav` tag pair.
---
## Overview
The various Nav tags work together to allow you to easily traverse your content upways and downways, sideways, slantways, longways, backways, squareways, frontways, and any other ways that you can think of.

This tag is designed to be used for top-level and multi-level navs.

## Navs or Collections

The nav tag supports both [navigations](/navigation) or multi-depth [collections](/collections).

You specify what kind you need by using the second tag part:

```
// The "links" nav
{{ nav:links }} ... {{ /nav:links }}
```

```
// The "pages" collection
{{ nav:collection:pages }} ... {{ /nav:collection:pages }}
```

If you use the tag on it's own without a second part, it will assume you want the `pages` collection. That's a super common thing to do, and the `statamic/statamic` repo comes bundled with it.

```
// Also the "pages" collection
{{ nav }} ... {{ /nav }}
```

You can also specify the navigation using the `handle` parameter:

```
{{ nav handle="links" }} ... {{ /nav }}
```

## Basic Example

A single level nav, much like something you'd have at the top of your site, can be built by looping through all the items in the nav and using their `title` and `url` variables in your HTML. Add a "current" state by checking for `is_current` and `is_parent`, and you're probably good to go.
```
<ul>
  {{ nav include_home="true" }}
    <li>
      <a href="{{ url }}"{{ if is_current || is_parent }} class="current"{{ /if }}>
        {{ title }}
      </a>
    </li>
  {{ /nav }}
</ul>
```

## Show the children of the current page

Use the `uri` to get the children of the current page.

```
<ul>
    {{ nav :from="uri" }}
        {{ unless no_results }}
            <li>
                <a href="{{ url }}">{{ title }}</a>
            </li>
        {{ /unless }}
    {{ /nav }}
</ul>
```

## Multi-level Nav Example Recursion {#multi-level}

Building an infinitely deep nav is possible by using recursion.

```
<ul>
   {{ nav :from="segment_1" }}
      <li>
         <a href="{{ url }}"{{ if is_current || is_parent }} class="on"{{ /if }}>{{ title }}</a>
         {{ if is_current || is_parent }}
            {{ if children }}
               <ul>{{ *recursive children* }}</ul>
            {{ /if }}
         {{ /if }}
      </li>
   {{ /nav }}
</ul>
```

The `{{ *recursive children* }}` tag will repeat the contents of the entire `{{ nav }}` tag using child elements, if they exist. As long as there are children to display, and we’re still on either the current or parent page of those children, the nav tag will traverse deeper. If your scoped variables have trouble making it through to the next recursion, you can glue them to children like this: `{{ *recursive children:my_scoped_variable* }}`.

Take the time to wrap your brain around this concept and learn to wield it and a powerful Jedi will you be.

> The Jedi have blessed us all with [even more recursive nav examples](/knowledge-base/recursive-nav-examples), so that you may have the high ground next time you're fighting that losing nav battle on Mustafar.
