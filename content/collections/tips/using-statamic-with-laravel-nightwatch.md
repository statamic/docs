---
id: 112bf1e2-9616-4d22-ac4e-9fbeba84f32b
title: 'Using Statamic Alongside Laravel Nightwatch'
intro: 'Nightwatch on Statamic burns through your event quota fast. Filter noisy events and keep monitoring costs under control.'
template: page
categories:
  - development
  - laravel
  - performance
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1776808338
---
## Why this happens

Statamic is a flat file CMS by default. To stay fast, the [Stache](/stache) and several other internals lean heavily on Laravel's cache layer. Every page view can easily trigger hundreds of cache reads and writes.

Nightwatch captures every `hit`, `miss`, `write`, `delete`, and `fail` event from the Cache layer. Multiply that by Statamic's cache churn and a modest amount of traffic will empty your monthly event quota in short order.

You have three good options, in order of bluntness.

## Option 1: Ignore all cache events

The simplest fix. Add this to your `.env` file and Nightwatch stops capturing cache events entirely:

```env
NIGHTWATCH_IGNORE_CACHE_EVENTS=true
```

You lose visibility into _all_ cache events, including any of your own. If you don't actively monitor cache behavior, this is the right call.

## Option 2: Reject Statamic's cache keys

If you want to keep monitoring your app's own cache usage, filter Statamic's keys out with `rejectCacheKeys()` in your `AppServiceProvider::boot()` method:

```php
use Laravel\Nightwatch\Facades\Nightwatch;

public function boot(): void
{
    Nightwatch::rejectCacheKeys([
        '/^stache::/',
        '/^statamic[.:]/',
        '/^nocache::/',
        '/^static-cache/',
        '/^asset-/',
        '/^responses/',
    ]);
}
```

These prefixes cover the Stache, the [static cache](/static-caching), [nocache](/tags/nocache) regions, asset metadata, and cached responses. Add-ons may introduce their own keys — check the Nightwatch Cache page in production to see what's still slipping through and tune the list.

### Using a callback instead

If regex isn't your thing, use `rejectCacheEvents()` with a closure:

```php
use Illuminate\Support\Str;
use Laravel\Nightwatch\Facades\Nightwatch;
use Laravel\Nightwatch\Records\CacheEvent;

Nightwatch::rejectCacheEvents(function (CacheEvent $cacheEvent) {
    return Str::startsWith($cacheEvent->key, [
        'stache::',
        'statamic.',
        'statamic::',
        'nocache::',
        'static-cache',
        'asset-',
        'responses',
    ]);
});
```

## Reject the entry schedule job

Statamic dispatches `HandleEntrySchedule` every minute to publish and unpublish scheduled entries. On a healthy site that's 43,200 queued jobs a month, all of them boring. Drop them before they hit Nightwatch:

```php
use Laravel\Nightwatch\Facades\Nightwatch;
use Laravel\Nightwatch\Records\QueuedJob;
use Statamic\Jobs\HandleEntrySchedule;

Nightwatch::rejectQueuedJobs(function (QueuedJob $job): bool {
    return $job->name === HandleEntrySchedule::class;
});
```

## Verify the fix

After deploying, open Nightwatch's **Cache** and **Queue** pages. You should see your event volume drop significantly and the top keys should now reflect your application, not Statamic's internals.

For a full list of filtering and sampling options, see the [Nightwatch Cache docs](https://nightwatch.laravel.com/docs/cache) and [Events overview](https://nightwatch.laravel.com/docs/events).
