---
id: 2080f786-9c04-4916-b77a-c62202ec4f07
title: 'Timezones'
intro: "Every developer's worst nightmare."
template: page
related_entries:
    - 7dfba904-8a74-40e1-b507-51cd2b5f6123
---

> **This guide is only relevant to sites running Statamic 6 and above.**

## UTC

It's best practice to store dates in the UTC timezone for consistency, and to convert the timezone just before displaying it.

We recommend leaving your timezone set to UTC. Statamic will convert dates to the timezone defined in `config/statamic/system.php` when appropriate.

```php
'display_timezone' => 'America/New_York',
```

By default, or when this is not explicitly set, it will also be `UTC`.


## Templating

Within templates, any dates will be [Carbon](https://carbon.nesbot.com) instances in the UTC timezone.

When converting a Carbon instance to a string, it will be automatically converted to your configured display timezone. For example:

```antlers
{{ date }} "December 25th, 2020"
````

Since this automatic conversion only happens when casting a Carbon instance to a string, when a date is passed to a modifier or tag, it will still be a UTC Carbon instance.

### Modifiers

For example, the `format` modifier will receive a UTC date:

```yaml
date: '2020-12-25 03:00' # This is UTC
```

```antlers
{{ date | format('Y-m-d H:i') }} "2020-12-25 03:00"
```

Since the format modifier received a UTC date, it applied the formatting for UTC. But, since we want it displayed in New York time as per our configuration, we expect to see it 5 hours earlier.

There are two options for this:
1. Apply the `timezone` modifier (or `tz` for short) before passing it along:
   ```antlers
   {{ date | tz | format(...) }} "2020-12-24 20:00"
   ```
2. Opt to convert dates in date modifiers in `config/statamic/system.php`:
   ```php
   'localize_dates_in_modifiers' => true,
   ```
   ```antlers
   {{ date | format(...) }} "2020-12-24 20:00"   
   ```
   _Note that this option will only convert dates when using date-related modifiers like `format`, `days_ago`, etc._
   
### Tags

If a tag _needs_ a Carbon instance in your display timezone, you can modify it before passing it:

::tabs
::tab antlers
```antlers
{{ my_tag :date="date|tz" }}
```
::tab blade
```blade
{{ Statamic::tag('my_tag')->date(
    $date->tz(config('statamic.system.display_timezone'))
) }}
```
::

Although, a tag shouldn't be expecting this of you.

## Custom Routes
If you're passing Carbon instances into templates yourself (eg. from a custom route), you should make sure they're all in UTC.

Under the hood, Statamic's `Localize` middleware uses Carbon's [`toStringFormat`](https://carbon.nesbot.com/docs/#api-formatting) setting to determine how dates are outputted when PHP calls `__toString()` on a Carbon instance.

You should ensure you're applying the `Localize` middleware to any custom routes in your application. If you're using `Route::statamic()` or the `statamic.web` middleware group, you'll already be using the `Localize` middleware.
