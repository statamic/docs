---
id: 0df63f01-4b97-4c15-89a9-015c02ea3748
blueprint: page
title: Task Scheduling
intro: "Manage scheduled tasks using Laravel's task scheduler."
template: page
related_entries:
  - 7202c698-942a-4dc0-b006-b982784efb03
  - ffa24da8-3fee-4fc9-a81b-fcae8917bd74
---
Statamic leverages task scheduling via Laravel's Task Scheduler.

In a nutshell, you can create a single cron job which will allow things to happen on a schedule, without any visitors needing to be on the site.

[Learn more about scheduling tasks in the Laravel docs](https://laravel.com/docs/13.x/scheduling)

## Running the scheduler

### In production

In production, you will need to set up a single once-per-minute cron entry that runs the `schedule:run` Artisan command.

Using a service like Laravel Forge makes this simple.

```sh
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### In development

Typically, you would not add a scheduler cron entry to your local development machine. Instead, you may use the `schedule:work` Artisan command. This command will run in the foreground and invoke the scheduler every minute until you terminate the command:

```sh
php artisan schedule:work
```   

[Learn more about running the scheduler](https://laravel.com/docs/13.x/scheduling#running-the-scheduler)

## Included tasks

The following tasks will be executed whenever the task scheduler is running, without you needing to enable anything.

### EntryScheduleReached

Statamic will dispatch a `Statamic\Events\EntryScheduleReached` event whenever a scheduled entry reaches its target date. This event is used in multiple places such as updating search indexes and invalidating caches.

The event will be dispatched on the minute _after_ the scheduled time.

#### Disabling

Statamic runs this task every minute, which means your application boots once a minute whether or not you have any scheduled entries. On usage-billed platforms like Laravel Cloud, you may prefer to opt out.

Set `STATAMIC_HANDLE_SCHEDULED_ENTRIES=false` in your `.env` file, or set the corresponding option in `config/statamic/system.php`:

```php
'handle_scheduled_entries' => env('STATAMIC_HANDLE_SCHEDULED_ENTRIES', true),
```

Entries will still go live at their scheduled time — an entry's status is derived from its date whenever it's read. What you lose is the `EntryScheduleReached` event, so your static cache and search indexes won't be updated until something else saves the entry.

### DeletePartialFormSubmissions

This job runs daily and deletes any [partial form submissions](/repositories/form-submission-repository#partial-submissions) older than the configured threshold (7 days by default).

You may configure the threshold (or disable automatic deletion entirely) using the `delete_partial_submissions_after` key in `config/statamic/forms.php`.


## Defining schedules

One way to add your own scheduled tasks is by adding items to your `routes/console.php` file.

```php
Schedule::command('my-command')->daily();

Schedule::job(new Heartbeat)->everyFiveMinutes();
```

[Learn more about defining schedules](https://laravel.com/docs/13.x/scheduling#defining-schedules)
