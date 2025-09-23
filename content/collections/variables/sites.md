---
id: 8e40a5f8-8825-45ed-b0b5-6f7cd3ce946c
blueprint: variables
types:
  - system
title: Sites
---
A collection containing all the configured sites as `Statamic\Sites\Site` objects which you can loop over using a tag pair.

```yaml
# resources/sites.yaml
english:
  name: English Site
  url: 'http://mysite.com/'
  locale: en_US
  direction: ltr
  attributes:
    foo: bar
french:
  name: French Site
  url: 'http://mysite.com.fr/'
  locale: en_FR
  direction: ltr
  attributes:
    foo: baz
```

::tabs

::tab antlers
```antlers
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
::tab blade
```blade
@foreach ($sites as $site)
  {{ $site->handle }}
  {{ $site->name }}
  {{ $site->locale }}
  {{ $site->short_locale }}
  {{ $site->url }}
  {{ $site->permalink }}
  {{ $site->direction }}

  {{ $site->attributes['foo'] }}
@endforeach
```
::

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
