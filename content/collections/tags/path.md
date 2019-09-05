---
title: Path
overview: Prepend a URL/string with the current site root.
parameters:
  -
    name: src
    type: string
    description: |
      The path to append to the site root.
  -
    name: absolute
    type: boolean *false*
    description: |
      Make the URL absolute if it isn't already.
id: b2ca728f-7591-4dd8-98cc-2f6cb2d5f8ea
---
## Usage {#usage}
This tag will ensure that the site root is prepended to the beginning of a string. It's especially useful when [running in a subdirectory](/knowledge-base/subdirectory-installation).

The site root is defined in `system.yaml`'s `locales` array in the `url` value for your locale. For example:

``` .language-yaml
locales:
  en:
    url: /
```

Assuming site root is `/`:

```
{{ path src="contact" }}
{{ path src="contact" absolute="true" }}
```

``` .language-output
/contact
http://example.com/contact
```

Assuming site root is `/subdirectory/`:

```
{{ path src="contact" }}
{{ path src="contact" absolute="true" }}
```

``` .language-output
/subdirectory/contact
http://example.com/subdirectory/contact
```

Assuming site root is `http://example.com/`:

```
{{ path src="contact" }}
{{ path src="contact" absolute="true" }}
```

``` .language-output
http://example.com/contact
http://example.com/contact
```
