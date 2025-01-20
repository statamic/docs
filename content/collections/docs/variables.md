---
title: 'Variables'
intro: Context-aware variables are always available in your [views](/views), giving you access to dynamic information about the current URL, user, loaded entry, site settings, and more.
template: variables.index
blueprint: page
mount: variables
id: 662a5918-ac0f-42a1-bf40-5a7a320e87e1
---
## Overview

Where appropriate, Statamic will inject data automatically for you to use in your views.

For example, when a view is loaded, you get automatic access to the variables applicable to it. You don't need to use a tag to "get" the data. If you're viewing an entry's URL, all of the [entry variables](#entry-variables) will just be there.

If you use a tag that does supply some data, it will typically make those variables available.

The [collection tag](/tags/collection) will loop over entries, again giving you access to entry variables within the loop. The [assets tag](/tags/assets) gives you [asset variables](#asset-variables), the [taxonomy tag](/tags/taxonomy) gives you [term variables](#term-variables), and so on.

The same is true for within tag pairs of [augmented values](/augmentation). Looping through a field configured to use an assets fieldtype? You'll be getting asset variables.


## Reaching into the cascade

Let's say you're on an entry's URL and you're looping through related entries. Within the loop, you'd have a `{{ title }}` which would be for the entry in that loop. But what if you want to get the `{{ title }}` from further up your view?

### The current page scope

Variables for the current page will be aliased into a `page` array. You can access this any time by prefixing a variable with `page:`.

```
{{ related_posts }}
    {{ title }} // The title of the entry in the loop.
    {{ page:title }} // The title of the entry used when loading the URL.
{{ /related_posts }}
```

### Explicitly defined scopes

You aren't limited to the `page` scope. You can use the `{{ scope }}` tag to take a "snapshot" of the variable context at any point of the template and use it for reference elsewhere.

For example, we can create a scope named `stuff`.

```
{{ scope:stuff }}
    {{ title }}

    {{ collection:blog }}
        {{ title }} // The title of the entry in the loop.
        {{ stuff:title }} // The title variable at the time the scope tag was used.
    {{ /collection:blog }}

{{ /scope:stuff }}
```


## Globals

You can create your own [Global variables](/globals), which all get injected into the variable cascade, ready to be used in your views.

## View front-matter

Inside Antlers views, you may define YAML front-matter. This may be a handy way to define variables without needing to add anything to content or blueprints.

To access this data, prefix the variables with `view:`.

```
---
foo: bar
---
{{ view:foo }}
```
```html
bar
```

:::tip
Front-matter defined in a `View` **must** be placed at the top of the file (even before things like `Antler` comments).
:::

## Available Variables

The following groups of variables are available in your views, depending on their context.
