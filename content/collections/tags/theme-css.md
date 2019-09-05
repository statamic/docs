---
title: CSS
overview: Get the URL to a stylesheet file in your theme.
parameters:
  -
    name: src
    type: 'string *theme name*'
    description: "The path to the css file, relative to the css directory.  You can leave off the extension, we know it's a .css file."
  -
    name: tag
    type: boolean *false*
    description: Enable this to output the full HTML tag.
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
id: 6b5093dc-dd82-4ae2-a9ff-53d4099d11e3
---
## Example {#example}
```
{{ theme:css src="style" }}
```
``` .language-output
/site/themes/redwood/css/style.css
```

If you leave off the `src` parameter, the tag will use the theme name as the filename.

```
{{ theme:css }}
```

``` .language-output
/site/themes/redwood/css/redwood.css
```

Add the `tag` parameter to output a `link` tag.

```
{{ theme:css src="style" tag="true" }}
```
``` .language-output
<link rel="stylesheet" href="/site/themes/redwood/css/style.css" />
```
