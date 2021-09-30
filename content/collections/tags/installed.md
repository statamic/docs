---
title: Installed
intro: Determine whether or not a Composer package is installed.
description: Determine whether or not a Composer package is installed.
id: d2d3c660-c7be-11eb-9345-0800200c9a66
---
A common use case for this tag is if you are building a reusable site (like a Starter Kit) and you'd like
to do something differently depending on whether a package is installed.

Use this as a single tag within an `if` statement:

```
{{ if {installed:statamic/seo-pro} }}
    {{ seo_pro:meta }}
{{ else }}
    {{ partial:seo }}
{{ /if }}
```

Or as a tag pair. If the package doesn't exist, then nothing between the tag will be output:

```
{{ installed:statamic/seo-pro }}
    {{ seo_pro:meta }}
{{ /installed:statamic/seo-pro }}
```

:::tip
You can pass any Composer package name into this tag. It's not limited to Statamic addons.
:::
