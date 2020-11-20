---
types:
  - system
id: 8e40a5f8-8825-45ed-b0b5-6f7cd3ce946c
---
A collection containing all the configured sites as `Statamic\Sites\Site` objects which you can loop over using a tag pair.

``` php
// config/statamic/sites.php

'sites' => [
    'english' => [
        'name' => 'English Site',
        'locale' => 'en_US',
        'url' => 'http://mysite.com/',
    ],
    'french' => [
        'name' => 'French Site',
        'locale' => 'en_FR',
        'url' => 'http://mysite.com.fr/',
    ]
]
```

```
{{ site }}
    {{ handle }}
    {{ name }}
    {{ locale }}
    {{ short_locale }}
    {{ url }}

{{ /site }}
```

``` output
english
English Site
en_US
en
http://mysite.com/

french
French Site
fr_FR
fr
http://mysite.com.fr/

```
