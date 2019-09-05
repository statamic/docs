---
title: Asset
overview: Get the URL to a file in your theme.
parameters:
  -
    name: type
    type: tag part
    description: 'You can optionally swap out the `asset` tag part for the asset type you wish. For example, `{{ theme:svg }}`'
  -
    name: src
    type: string
    description: >
      The path to the file, relative to the
      theme directory.
  -
    name: cache_bust
    type: 'boolean *false*'
    description: >
      Setting this to `true` will add the timestamp of the asset to the end of
      the URL in a `?v=` query param.
  -
    name: absolute
    type: boolean *false*
    description: Render the URL in an absolute format.
id: de348605-5489-4282-9257-bd9ffd92438e
---
## Explicit mode {#explicit-mode}
Using `{{ theme:asset }}` requires that you enter the complete path to the asset in the `src` parameter.

```
{{ theme:asset src="img/hat.jpg" }}
```

``` .language-output
/site/themes/redwood/img/hat.jpg
```

## Shorthand mode {#shorthand-mode}
You can swap out the `asset` tag part for the initial directory to make your templates a little more readable.
Here we're using `{{ theme:img }}` to go directly into the `img` subfolder.

```
{{ theme:img src="hat.jpg" }}
```

``` .language-output
/site/themes/redwood/img/hat.jpg
```
