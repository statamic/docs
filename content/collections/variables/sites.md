---
id: 8e40a5f8-8825-45ed-b0b5-6f7cd3ce946c
blueprint: variables
types:
  - system
title: Sites
---
A collection containing all the configured sites as `Statamic\Sites\Site` objects which you can loop over using a tag pair.

``` php
// config/statamic/sites.php

'sites' => [
    'english' => [
        'name' => 'English Site',
        'locale' => 'en_US',
        'url' => 'http://mysite.com/',
        'direction' => 'ltr',
        'attributes' => [
            'foo' => 'bar',
        ]
    ],
    'french' => [
        'name' => 'French Site',
        'locale' => 'en_FR',
        'url' => 'http://mysite.com.fr/',
        'direction' => 'ltr',
        'attributes' => [
            'foo' => 'baz',
        ]
    ]
]
```

```
{{ sites }}
    {{ handle }}
    {{ name }}
    {{ locale }}
    {{ short_locale }}
    {{ url }}
    {{ direction }}
    {{ attributes }}
        {{ foo }}
    {{ /attributes }}

{{ /sites }}
```

```html
english
English Site
en_US
en
http://mysite.com/
ltr
bar

french
French Site
fr_FR
fr
http://mysite.com.fr/
ltr
baz

```
