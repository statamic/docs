---
title: Cache
description: Caches a view chunk for performance gains
intro: >
  If you find that a particular chunk of your view logic is the cause of a performance hit — perhaps you're fetching and filtering huge amount of content, or pulling data from an API, caching that portion of your template can remove alleviate any slowdown.
parameters:
  -
    name: for
    type: string
    description: 'The length of time to cache this section. Use plain English to specify the length, eg. `2 hours`, `5 minutes`, etc.'
  -
    name: scope
    type: 'string'
    description: 'Sets the cache scope. The default `site` scope will cache one instance per tag for the entire site, while a `page` scope will create a unique cache per URL.'
   -
    name: key
    type: 'string'
    description: 'Sets the key used to store the value in the Laravel cache. `key` can't be used at the same time as `scope`.'
stage: 4
id: 1d0d2d1f-734b-4360-af7a-6792bf670bc7
---
## Overview

After an initial render, markup inside a cache tag will be pulled from a cached,statically cached copy until invalidated.


```
{{ cache for="5 minutes" }}
  {{ collection:stocks limit="5000" }}
    <!-- probably lots of stuff happening -->
  {{ /collection:stocks }}
{{ /cache }}
```

It really only makes sense to use the cache tag if you're not using another full-site type of caching, like static or full measure. There's nothing to be gained by caching a cache. That would be like buying four $5 bills with a $20. What have you gained other than a fatter wallet?
