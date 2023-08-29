---
id: 221fadae-5284-42a6-a1df-aad326e5fa70
blueprint: tag
title: 'No Cache'
description: 'Keeps a chunk of your template dynamic inside of an otherwise cached area.'
intro: When using a broader caching solution (like [static caching](/static-caching) or the [cache tag](/tags/cache)) you may want to keep a chunk of your template dynamic.
---
## Overview

When using [Static Caching](/static-caching) or the [cache tag](/tags/cache), the rendered contents will be remembered for the next request. That's great for performance, but if you have something in there that you'd like to keep dynamic (such as authenticated user data, randomized elements, or listings), you'd normally have to disable static caching for the whole page.

With the `nocache` tag, you can keep the entirety of the page cached (when using Static Caching) or chunks of the page cached (when using the cache tag), with certain parts left as as dynamic:

```
{{ nav }} ... {{ /nav }}

{{ nocache }} {{# [tl! focus:6] #}}
    {{ if logged_in }}
        Welcome back, {{ current_user:name }}
    {{ else }}
        Hello, Guest!
    {{ /if }}
{{ /nocache }}

{{ content }}
```

## Forms

Before the `nocache` tag existed, a common reason to exclude a page from static caching would be if there was a form on there.

Forms contain a CSRF token for security, which is unique to each user visiting. If you submit the form using someone elses token (which could happen when static caching is enabled) the form won't work.

CSRF tokens are now updated automatically.

However, if your form has logic in it, like validation or success messages, you'll need to keep the `form:create` dynamic by wrapping in `nocache` tags.

```
{{ nocache }} {{# [tl!++] #}}
    {{ form:create }}
        ...
    {{ /form:create }}
{{ /nocache }} {{# [tl!++] #}}
```

## Blade

You can use the "no cache" feature in Blade too, although you should use the dedicated Blade directive instead of trying to use the tag.

To keep a part of your template dynamic, move it into a partial then use the `@nocache` directive just like you would use the `@include` directive.

```blade
@include('mypartial') {{-- this will be cached --}}
@nocache('mypartial') {{-- this will be dynamic --}}
```

## Caveats

Most of the time you can probably get away with wrapping something in a `nocache` tag and it will just work! However there are some situations where you will need to be more aware of how the tag works in order to get predictable results.


### When to wrap

For example, let's say you have a collection of stocks. Each entry contains information about the stock, except for the price. You have a custom tag that will get the up-to-the-second stock price using an API.

```
{{ collection:stocks }}
    <li>
        {{ company }}
        {{ symbol }}
        {{ get_price :of="symbol" }}
    </li>
{{ /collection:stocks }}
```

If you turned on static caching now, then the whole listing would be cached, including the prices.

In this example, you should put a `nocache` _inside_ the loop.

```
{{ collection:stocks }}
    <li>
        {{ company }}
        {{ symbol }}
        {{ nocache }} {{# [tl!++] #}}
            {{ get_price :of="symbol" }}
        {{ /nocache }} {{# [tl!++] #}}
    </li>
{{ /collection:stocks }}
```

By putting it inside the loop, it means that the `collection:stocks` tag wouldn't need to re-query for entries on each subsequent request.

You'd then also rely on [static caching invalidation rules](/static-caching#invalidation) to invalidate the entire page when one of your stock entries change.

An example where you would want to put a `nocache` tag _around_ a loop would be when re-querying every request would be important. For example, a randomized section:

```
{{ nocache }}
    {{ collection:blog featured:is="true" sort="random" }}
        ...
    {{ /collection:blog }}
{{ /nocache }}
```

### Context

The `nocache` tag will remember the "context", which are the variables available at that point in the template.

Here we'll use a loop to illustrate what happens:

```yaml
title: Movie Reviews
reviews:
  - name: Top Gun
    rating: 58%
  - name: Citizen Kane
    rating: 99%
  - name: Jack and Jill
    rating: 3%
```

```
{{ reviews }}
    <div class="movie">
        {{ nocache }}
            {{ name }} {{ rating }} {{ title }}
        {{ /nocache }}
    </div>
{{ /reviews }}
```

```
<div class="movie"> Top Gun 58% Movie Reviews </div>
<div class="movie"> Citizen Kane 99% Movie Reviews </div>
<div class="movie"> Jack and Jill 3% Movie Reviews </div>
```

Within each of those nocache tags, you'd have access to the iteration specific variables:
  - `name`, `rating` (e.g. `name` would be `Top Gun`, then `Citizen Kane`, etc)
  - special loop variables (e.g. `first`, `last`, `count`)
  - any cascading variables (e.g. from outer tags, or top level page variables like `now`, `page`, etc)

All of the [top level variables](/variables) will be filtered out and replaced with fresh versions on subsequent requests.

Now lets say you update `title` to `Ratings` and Top Gun's `rating` to `60%`. The first line out of output will now look like this:

```
<div class="movie"> Top Gun 58% Ratings </div>
```

Only the `title`'s change would be reflected, since the `reviews` value was remembered. If you wanted this to be dynamic, you should wrap the loop rather than putting it inside the loop, as explained in [when to wrap](#when-to-wrap).

```
{{ nocache }} {{# [tl!++] #}}
    {{ reviews }}
        <div class="movie">
            {{ nocache }} {{# [tl!--] #}}
                {{ name }} {{ rating }} {{ title }}
            {{ /nocache }} {{# [tl!--] #}}
        </div>
    {{ /reviews }}
{{ /nocache }} {{# [tl!++] #}}
```
```
<div class="movie"> Top Gun 60% Ratings </div>
```

### Usage with default Laravel Routes

When you are using a custom Laravel Route, you might encounter that the nocache tag will return ``NOCACHE_PLACEHOLDER``. For the placeholder to be replaced, ensure that the route has the ``statamic.web`` middleware applied.

## Full Measure Static Caching

When using the `file` static cache driver (aka. "full measure") the pages will be stored as plain `html` files on your server.

On any pages that use a `nocache` tag, a small snippet of JavaScript will be injected just before the closing `</body>` tag.

The nocache fragments will be retrieved from the server using an AJAX request. Because of this, there may be a slight delay before the fragments are replaced. This is similar to a "FOUC" or "flash of unstyled content". In this case, there will be empty `<span>` tags until they are replaced by the real fragments.

You can optionally define the inner html of these `span` tags, if you wanted to have a "loading" state, for example.

```php
use Statamic\Facades\StaticCache;

StaticCache::nocachePlaceholder('Loading...');
// or
StaticCache::nocachePlaceholder('<svg>...</svg>');
```

You may wish to run some additional Javascript code once the nocache fragments on the page have been replaced, to enable this a custom event is dispatched that you may register an event listener for.

```js
document.addEventListener('statamic:nocache.replaced', (event) => {
    alert('nocache fragments have been replaced!');
});
```
