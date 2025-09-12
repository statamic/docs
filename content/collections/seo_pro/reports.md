---
id: 700c8a78-0878-455d-b7d3-6cc2660c4d0a
blueprint: seo_pro
title: Reports
---
You may generate an SEO report that checks all the pages of your site against a number of tests. The tests include mandatory items like title tag uniqueness, or suggested items like URLs being no more than 3 segments. Failing a mandatory item will result in a fail where failing a suggested item will result in a warning.

Reports will stick around until deleted, so you are free to compare reports to see how you are progressing.

You may generate a report through the Control Panel, or by running `php please seo-pro:generate-report`.

## Queuing Reports

Depending on the size of your site, generating a report may take a while. To prevent request timeouts, you may enable queues, and the reports will be truly queued in the background.

> A popular choice is to use a [Redis](https://laravel.com/docs/11.x/redis) store and [queue driver](https://laravel.com/docs/11.x/queues#driver-prerequisites), along with [Laravel Horizon](https://laravel.com/docs/11.x/queues#driver-prerequisites) for managing your Redis queues.

## Widget

You may add a reports widget to your dashboard to get a quick insight into your site's SEO status. Add the following to your `widgets` array within `config/statamic/cp.php` to show the latest report's score:

```php
'widgets' => [
    [
        'type' => 'seo_pro',
        'width' => 50,
    ]
],
```