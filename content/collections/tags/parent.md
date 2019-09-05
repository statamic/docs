---
title: Parent
overview: Grab the current page's parent's page data. You follow that?
parameters:
  -
    name: field
    type: tag part
    description: |
      The name of the field. This is not actually a parameter, but part of the tag itself.
      For example, `{{ parent:title }}`
id: 932ae2b5-0ff0-40e3-b8a4-1c71784917e4
---
## Example {#example}

### Fetching and iterating over values

``` .language-yaml
# pages/about/index.md
---
title: About
stuff:
  one: uno
  two: dos
facts:
  - potatoes have eyes
  - bacon gives you superpowers
---
```

``` .language-yaml
# pages/about/team/index.md
---
title: Team
---
```

If you were on `/about/team` and use the following template:

```
{{ title }}

{{ parent:title }}

{{ parent:stuff }} {{ one }}, {{ two }} {{ /parent:stuff }}

{{ parent:facts }} {{ value }}, {{ /parent:facts }}
```

You would get this:

``` .language-output
Team

About

uno, dos

potatoes have eyes, bacon gives you superpowers,
```

### Without a tag part

You can also use the parent tag without a tag part. This can do two things:

As a single tag, it'll just output the parent's URL.

```
{{ parent }}
```

``` .language-output
/about
```

As a tag pair, it'll make all the parent's values available:

```
{{ parent }} {{ title }} {{ /parent }}
```

``` .language-output
About
```

**Note**: Do not both a single and tag pair in the same template. It'll get confused by which closing tag belongs to which
opening tag. Feel free to put them in partials.