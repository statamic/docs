---
id: 577004ae-5fa4-4535-b34f-cd8e7f721cbb
blueprint: troubleshooting
title: 'Email not sending'
intro: Email can be difficult to debug when it seems like you've set everything up correctly.
template: page
categories:
  - troubleshooting
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821385
---
## Email Test Utility
The most basic way to test that email is working is to use the Email utility in the control panel.

Head to Utilities > Email. In there you can see all your mail related settings. Maybe you can spot an incorrect setting.

On this page you can also send a test email. If you do that and see a success message but no email, here's some suggestions:

## Queue
One thing you may want to check is that if you've configured a queue, that the queue is actually running.

The success message could mean that it was successfully queued, but the lack of any email is because the queued job was never executed.

Locally, run the queue worker:

```shell
php artisan queue:listen
```

Or on production, make sure you a worker configured to run the `queue:work` command.

## Horizon

If you're using Laravel Horizon, make sure that you didn't just `composer require` it, but that you also installed it using `artisan horizon:install`.  
