---
id: 221fadae-5284-42a6-a1df-aad326e5fa70
blueprint: tag
title: 'No Cache'
description: 'Keeps a chunk of your template dynamic inside of an otherwise cached area.'
intro: When using a broader caching solution (like [static caching](/static-caching) or the [cache tag](/tags/cache)) you may want to keep a chunk of your template dynamic.
---
## Overview

When using [Static Caching](/static-caching) or the [cache tag](/tags/cache), the rendered contents will be remembered for the next request. That's great for performance, but if you have something in there that you'd like to keep dynamic (such as authenticated user data, randomized elements, or listings), you'd normally have to disable static caching for the whole page.

With the `nocache` tag, you can keep the entirety of the page cached (when using Static Caching) or chunks of the page cached (when using the cache tag), with specific parts remaining dynamic:

::tabs

::tab antlers
```antlers
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
::tab blade
```blade
<statamic:nav> ... </statamic:nav>

<statamic:nocache> {{-- [tl! focus:6] --}}
   @if ($logged_in)
      Welcome back, {{ $current_user->name }}   
   @else
      Hello, guest!
   @endif
</statamic:nocache>

{!! $content !}}
```
::

## Forms

Before the `nocache` tag existed, a common reason to exclude a page from static caching would be if there was a form on there.

Forms contain a CSRF token for security, which is unique to each user visiting. If you submit the form using someone elses token (which could happen when static caching is enabled) the form won't work.

CSRF tokens are now updated automatically.

However, if your form has logic in it, like validation or success messages, you'll need to keep the `form:create` dynamic by wrapping in `nocache` tags.

::tabs

::tab antlers
```antlers
{{ nocache }} {{# [tl!++] #}}
    {{ form:create }}
        ...
    {{ /form:create }}
{{ /nocache }} {{# [tl!++] #}}
```
::tab blade
```blade
<statamic:nocache> {{-- [tl!++] --}}
   <statamic:form:create>
      ...
   </statamic:form:create>
</statamic:nocache> {{-- [tl!++] --}}
```
::

## Blade

You can use the "no cache" feature in Blade too, although you should use the dedicated Blade directive or the Statamic Elements tag instead of trying to use `Statamic::tag`.

::tabs

::tab nocache Directive

To keep a part of your template dynamic, move it into a partial then use the `@nocache` directive just like you would use the `@include` directive.

```blade
@include('mypartial') {{-- this will be cached --}}
@nocache('mypartial') {{-- this will be dynamic --}}
```
::tab Statamic Tags

If you'd like to make a section of the current template dynamic without extracting a dedicated partial, you may use the `<statamic:nocache>` tag:

```blade
<statamic:nocache>
  ...
</statamic:nocache>
```
::

## Caveats

Most of the time you can probably get away with wrapping something in a `nocache` tag and it will just work! However there are some situations where you will need to be more aware of how the tag works in order to get predictable results.


### When to wrap

For example, let's say you have a collection of stocks. Each entry contains information about the stock, except for the price. You have a custom tag that will get the up-to-the-second stock price using an API.

::tabs
::tab antlers
```antlers
{{ collection:stocks }}
    <li>
        {{ company }}
        {{ symbol }}
        {{ get_price :of="symbol" }}
    </li>
{{ /collection:stocks }}
```
::tab blade
```blade
<statamic:collection:stocks>
   <li>
      {{ $company }}
      {{ $symbol }}
      <statamic:get_price :of="$symbol" />
   </li>
</statamic:collection:stocks>
```
::

If you turned on static caching now, then the whole listing would be cached, including the prices.

In this example, you should put a `nocache` _inside_ the loop.

::tabs
::tab antlers
```antlers
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
::tab blade
```blade
<statamic:collection:stocks>
   <li>
      {{ $company }}
      {{ $symbol }}
      <statamic:nocache> {{-- [tl!++] --}}
        <statamic:get_price :of="$symbol" />
      </statamic:nocache> {{-- [tl!++] --}}
   </li>
</statamic:collection:stocks>
```
::

By putting it inside the loop, it means that the `collection:stocks` tag wouldn't need to re-query for entries on each subsequent request.

You'd then also rely on [static caching invalidation rules](/static-caching#invalidation) to invalidate the entire page when one of your stock entries change.

An example where you would want to put a `nocache` tag _around_ a loop would be when re-querying every request would be important. For example, a randomized section:

::tabs
::tab antlers
```antlers
{{ nocache }}
    {{ collection:blog featured:is="true" sort="random" }}
        ...
    {{ /collection:blog }}
{{ /nocache }}
```
::tab blade
```blade
<statamic:nocache>
   <statamic:collection:blog
     featured:is="true"
     sort="random"
   >
     ...
   </statamic:collection:blog>
</statamic:nocache>
```
::

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

::tabs
::tab antlers
```antlers
{{ reviews }}
    <div class="movie">
        {{ nocache }}
            {{ name }} {{ rating }} {{ title }}
        {{ /nocache }}
    </div>
{{ /reviews }}
```
::tab blade

```blade
@foreach ($reviews as $review)
  <div class="movie">
    <statamic:nocache>
      {{ $review->name }} {{ $review->rating}} {{ $review->title }}
    </statamic:nocache>
  </div>
@endforeach
```
::

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

::tabs
::tab antlers
```antlers
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
::tab blade
```blade
<statamic:nocache> {{-- [tl!++] --}}
    @foreach ($reviews as $review)
        <div class="movie">
            <statamic:nocache> {{-- [tl!--] --}}
                {{ $review->name }} {{ $review->rating }} {{ $review->title }}
            </statamic:nocache> {{-- [tl!--] --}}
        </div>
    @endforeach
</statamic:nocache> {{-- [tl!++] --}}
```
::

```
<div class="movie"> Top Gun 60% Ratings </div>
```

#### Performance
Sometimes, you may notice the contents of the `nocache` taking a while to load. This is often caused by Statamic hydrating all of the variables from the context.

To improve performance, you can explicitly select the variables you need:

::tabs
::tab antlers
```antlers
{{ nocache select="this|that" }}
```
::tab blade
```blade
<statamic:nocache
  select="this|that"
>
</statamic:nocache>
```
::

Alternatively, you can use the `@auto` placeholder for Statamic to extract the variables from the template (this is similar to the `@shallow` placeholder in the nav tag):

::tabs
::tab antlers
```antlers
{{ nocache select="@auto" }}
```
::tab blade
```blade
<statamic:nocache
  select="@auto"
>

</statamic:nocache>
```
::

:::tip
It's worth noting, the `nocache` tag won't be able to extract variables used inside partials or PHP files like custom tags. You will need to explicitly define the variables you need in these cases.
:::

You can also combine them to extract the variables from the template and add additional ones:

::tabs
::tab antlers
```antlers
{{ nocache select="@auto|this|that" }}
```
::tab blade
```blade
<statamic:nocache
  select="@auto|this|that"
>

</statamic:nocache>
```
::

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

## Database

Behind the scenes, the `nocache` tag needs to store some data somewhere. This includes the contents of the template chunks, the available variables at that point of the template, which pages it's being used on, etc.

By default, these are stored in the cache. However, with increased traffic or site size, you may eventually run into resource usage issues. In this case, it's possible to store the nocache data in a database.

1. Configure the database driver in `config/statamic/static_caching.php`:
    ```php
    'nocache' => 'database'
    ``` 
2. Generate the migration:
    ```sh
    php please nocache:migration
    ```
3. Run the migration:
    ```sh
    php artisan migrate
    ```
4. Clear the static cache. Things may be out of sync if you have previously cached pages but the nocache regions don't exist in the DB yet.
    ```sh
    php please static:clear
    ```
