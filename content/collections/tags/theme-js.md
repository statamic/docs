---
title: JS
id: 7b0b7fd8-4b7a-42ae-921b-ddc7383e12f2
overview: Get the URL to a javascript file in your theme.
parameters:
  -
    name: src
    type: string
    description: "The path to the Javascript file, relative to the js directory.  You can leave off the extension, we know it's a .js file."
  -
    name: version
    type: 'boolean *false*'
    description: >
      If you are using Elixir to manage your
      theme assets, setting this to `true`
      will use the manifest to output the
      filename.
  -
    name: cache_bust
    type: 'boolean *false*'
    description: >
      Setting this to `true` will add the timestamp of the asset to the end of
      the URL in a `?v=` query param. Use this to version files if you are
      _not_ using Elixir.
  -
    name: absolute
    type: boolean *false*
    description: Render the URL in an absolute format.
---
## Example {#example}
```
{{ theme:js src="scripts" }}
```
``` .language-output
/site/themes/redwood/js/scripts.js
```

If you leave off the `src` parameter, the tag will use the theme name as the filename.

```
{{ theme:js }}
```

``` .language-output
/site/themes/redwood/js/redwood.js
```

Add the `tag` parameter to output a `script` tag.

```
{{ theme:js src="scripts" tag="true" }}
```
``` .language-output
<script src="/site/themes/redwood/js/scripts.js"></script>
```
