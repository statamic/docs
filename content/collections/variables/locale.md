---
id: abe54934-3204-4cd3-bf4d-d9ef1d2c5738
types:
  - global
---
The site's locale key as defined in your `system.yaml`'s `locales` array.

``` .language-yaml
locales:
  en:
    name: English
    full: en_US
    url: http://mysite.com/
```

```
{{ locale }}
```

``` .language-output
en
```
