---
types:
  - global
id: 2cd42640-5c57-4bbe-a56b-bb234b8a31c2
---
The site's locale name as defined in your `system.yaml`'s `locales` array.

``` .language-yaml
locales:
  en:
    name: English
    full: en_US
    url: http://mysite.com/
```

```
{{ locale_name }}
```

``` .language-output
English
```
