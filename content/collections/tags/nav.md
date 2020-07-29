---
title: Nav
overview: >
  The nav tags are designed to help your users navigate through your hierarchy of pages. They work together to allow you to easily traverse your content upways and downways, sideways, slantways, longways, backways, squareways, frontways, and any other ways that you can think of.
description: Create site navigation based off your Pages structure.
id: ed746608-87f9-448f-bf57-051da132fef7
is_parent_tag: true
parameters:
  -
    name: from
    type: string
    description: "The starting point for your navigation. If unspecified, it'll use the current URI."
  -
    name: max_depth
    type: 'integer 2*'
    description: >
      The maximum number of subdirectory
      levels to traverse, letting you build a
      multi-level nav.
  -
    name: limit
    type: integer
    description: Limit the total items returned.
  -
    name: show_unpublished
    type: 'boolean *false*'
    description: "Unpublished content is, by it's very nature, unpublished. That is, unless you show it by turning on this parameter."
  -
    name: include_entries
    type: 'boolean *false*'
    description: >
      Whether entries mounted under a page
      should be included as part of the
      navigation.
  -
    name: sort
    type: string
    description: >
      The field by which the pages will be
      sorted. For example, specify `title` to
      sort alphabetically by the title field.
  -
    name: include_home
    type: 'boolean *false*'
    description: >
      You can choose to turn off the home page
      in the tree, opting to start the crumbs
      from the first level nav item.
  -
    name: include_root
    type: 'boolean *false*'
    description: >
      You can choose to turn off the root page (whatever you've provided to the `from` parameter)
      in the tree, opting to start the crumbs from the first level nav item. (When from is the root, this is
      the same as the `include_home` parameter)
  -
    name: exclude
    type: 'string|array'
    description: >
      A single URL, or a list of multiple pipe-separated URLs, to be excluded.
  -
    name: filter
    type: wizardry
    description: >
      Filter the tree by using a special conditions syntax, the same as the [Collections tag](/tags/collection). View the [available conditions](/conditions).
  -
    name: supplement_taxonomies
    type: boolean *true*
    description: >
      By default, Statamic will convert taxonomy term values into actual term objects that you may loop through.
      This has some performance overhead, so you may disable this for a speed boost if taxonomies aren't necessary.
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
### Basic Example

Here is an example to output your nav on the front-end.

```
{{ nav include_home="true" }}
  {{ title }}
{{ /nav }}
```

Here Statamic will just output the names of all your navigation items. Now that we've output the nav we probably want to sprinkle some markup between our items. We can do something like this:

```
<ul>
  {{ nav include_home="true" }}
    <li>
      <a href="{{ url }}"{{ if is_current || is_parent }} class="on"{{ /if }}>{{ title }}</a>
    </li>
  {{ /nav }}
</ul>
```

## Recursion {#recursion}

It's possible to use recursive tags for semi-automatically creating deeply-nested lists of links as your navigations. A sample set-up looks something like this:

```
<ul>
   {{ nav from="/{segment_1}" max_depth="2" }}
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

The `{{ *recursive children* }}` tag will repeat the contents of the entire `{{ nav }}` tag using child elements if they exist. This means that as long as there are children to display, and we’re still on either the current or parent page of those children, the nav tag will traverse deeper. If your scoped variables have trouble making it through to the next recursion, you can glue them to children like this: `{{ *recursive children:my_scoped_variable* }}`.

It’s an admittedly weird concept, and might take some fiddling with to truly understand, but is very powerful when fully understood. Take the time. Learn to wield it. A powerful Jedi will you be.

## Hidden Pages {#hidden-pages}

A common use-case for navigation is to make some pages "hidden", which means to hide them from the nav, but keep them
available when accessed directly.

Note: In Statamic v1, you should set the status to hidden or prefix the filename with an underscore. In v2, this method
has been removed in favor of the following workflow.

1. Add a field to your page fieldset that'll be used to indicate a "hidden" page:

   ``` .language-yaml
   fields:
      is_hidden:  # the field name can be whatever you want
        type: toggle
        display: Hide from navigation
   ```

2. In your `nav` tag, use the [conditions syntax](/conditions) to remove any hidden pages:

   ```
   {{ nav from="/" is_hidden:isnt="true" }}
       ...
   {{ /nav }}
   ```

   This is saying, only show pages where the `is_hidden` field _isn't set to true_. That will leave you with unhidden pages.
   Remember, the field can be named whatever you want.
