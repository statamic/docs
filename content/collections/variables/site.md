---
id: e6fdbeb6-7808-45b0-b012-89a34993778b
blueprint: variables
types:
  - system
title: Site
---
The current site being targeted in the request.

It's a `Statamic\Sites\Site` object and can be used as a single tag or tag pair.

``` php
// config/statamic/sites.php

'sites' => [
    'default' => [
        'name' => 'My Statamic Site',
        'locale' => 'en_US',
        'url' => 'http://mysite.com/',
        'direction' => 'ltr',
        'attributes' => [
            'foo' => 'bar',
        ],
    ]
]
```

As a single tag, it will output the handle of the site:

```
{{ site }}
```

``` output
default
```

As a tag pair, you can access additional information:

```
{{ site }}
    {{ handle }}
    {{ name }}
    {{ locale }}
    {{ short_locale }}
    {{ url }}
    {{ direction }}
    {{ attributes }}
        {{ foo }}
    {{ /attributes }}
{{ /site }}
```

``` output
default
My Statamic Site
en_US
en
http://mysite.com/
```

You can also access those variables directly as single tags:

```
{{ site:name }}
{{ site:attributes:foo }}
```

``` output
My Statamic Site
bar
```
