---
id: 1fb22c41-eb1e-4a14-98fc-9d3158871476
blueprint: modifiers
title: Pathinfo
modifier_types:
  - string
  - utility
---
Get information about a file path.

``` yaml
path: '/local/file/example.pdf'
```

``` antlers
{{ path | pathinfo }}
{{ path | pathinfo:extension }}
```

```php
[
    'dirname'   => '/local/file',
    'basename'  => 'example.pdf',
    'filename'  => 'example',
    'extension' => 'pdf',
]
```

```
pdf
```