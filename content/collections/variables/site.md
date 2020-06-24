---
handle: 'site'
types:
  - system
id: 5e155f3b-7b1f-4e6c-ba08-7b62d522050f
---
## Overview

The site variable acts as an container for site related information.

## site and site:handle

The handle of the site or in other words: the key you configured in your `config/sites.php`. An alias of `site:handle`.

```
{{ site }}
{{ site:handle }}
```

``` .language-output
default
default
```

## site:locale

The locale of the site.

```
{{ site:locale }}
```

``` .language-output
en_US
```

## site:name

The name of the site.

```
{{ site:name }}
```

``` .language-output
Statamic Documentation
```

## site:short_locale

The short locale of the site.

```
{{ site:short_locale }}
```

``` .language-output
en
```

## site:url

The URL of the site. Aliased by `homepage`.

```
{{ site:url }}
```

``` .language-output
https://docs.statamic.com/
```
