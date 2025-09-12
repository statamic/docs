---
id: 41cd0830-04f4-43bd-875e-46f0d608be9e
blueprint: seo_pro
title: 'Available Hooks'
intro: 'Hooks are a powerful extension feature of Statamic, and SEO Pro provides a few Content Linking hooks. To learn more about Hooks, consider reading [their associated documentation](/extending/hooks).'
---
## Link Manager Index Query: `query`

Triggered before the index query for the Link Manager table is executed. The payload will be an object with a `query` property.

```php
use Statamic\SeoPro\Hooks\CP\EntryLinksIndexQuery;

EntryLinksIndexQuery::hook('query', function ($payload, $next) {
  $payload->query; // a QueryBuilder instance.
  
  return $next($payload);
});
```

## Global Automatic Links Index Query: `query`

Triggered before the index query for the Global Automatic Links table is executed. The payload will be an object with a `query` property.

```php
use Statamic\SeoPro\Hooks\CP\AutomaticLinksIndexQuery;

AutomaticLinksIndexQuery::hook('query', function ($payload, $next) {
  $payload->query; // a QueryBuilder instance.
  
  return $next($payload);
});
```