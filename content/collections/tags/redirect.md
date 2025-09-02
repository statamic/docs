---
title: Redirect
description: Redirects visitor to another URL
intro: |
  Anytime this tag is rendered — whether in a template, partial, or content, Statamic will redirect the visitor to the specified URL.
parameters:
  -
    name: url
    type: string
    description: Destination URL
  -
    name: to
    type: string
    description: Alias of `url`
  -
    name: route
    type: string
    description: Instead of entering a URL, you can specify a route name. Any other parameters will be passed along as route parameters.
  -
    name: response
    type: integer
    description: 'The HTTP response code to use. Default: `302` (temporary).'
id: 444d1109-ed96-4162-b86d-24b39f569220
---
## Redirecting to URLs

Let's redirect visitors to the homepage if they're not logged in.

::tabs

::tab antlers
```antlers
{{ if ! logged_in }}
  {{ redirect to="/" }}
{{ /if }}
```
::tab blade
```blade
@if (! $logged_in)
  <s:redirect to="/" />
@endif
```
::

How about RickRolling visitors if it's April Fool's Day?

::tabs

::tab antlers
```antlers
{{ if (now|format:m-d) == "04-01" }}
  {{ redirect to="https://www.youtube.com/watch?v=dQw4w9WgXcQ" }}
{{ /if }}
```
::tab blade
```blade
@if (Statamic::modify($now)->format('m-d')->fetch() == '04-01')
  <s:redirect to="https://www.youtube.com/watch?v=dQw4w9WgXcQ" />
@endif
```

::


## Named Routes

You may redirect to named routes with the `route` parameter. Anything else will be passed along as route parameters.

```php
Route::get('products/{product}/{size}', fn($product, $size) => ...)
     ->name('products.show');
```

::tabs

::tab antlers
```antlers
{{ redirect route="products.show" product="socks" size="large" }}
// /products/socks/large
```
::tab blade
```blade
<s:redirect
  route="products.show"
  product="socks"
  size="large"
/>
```
::
