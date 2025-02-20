---
id: 6ff17a73-c631-433b-9727-0f72fa543807
blueprint: modifiers
title: 'To qs'
modifier_types:
  - array
---
Converts an array or array-like value into a query string using Laravel's [Arr::query()](https://laravel.com/docs/11.x/helpers#method-array-query) helper method.

```yaml
$params = [
    'mode' => 'plaid',
    'area' => [51, 52],
    'hat' => null,
    'transportation' => [
        'bike' => true,
        'delorian' => false,
    ],
];
```

```antlers
<a href="/search?{{ params | to_qs }}">Search Now</a>
```

```html
<a href="/search?mode=plaid&area%5B0%5D=51&area%5B1%5D=52&transportation%5Bbike%5D=1&transportation%5Bdelorian%5D=0">Search Now</a>
```
