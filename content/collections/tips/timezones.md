---
id: 2080f786-9c04-4916-b77a-c62202ec4f07
title: 'Timezones'
intro: "Every developer's worst nightmare."
template: page
related_entries:
    - 7dfba904-8a74-40e1-b507-51cd2b5f6123
---

> **This guide is only relevant to sites running Statamic 6 and above.**

Whenever Statamic passes dates into templates, the dates will be in UTC, rather than your local timezone.

UTC serves as a sort of "normalization" format for dates, making it much easier for Statamic to know how to localize them based on the user's preferences.

When you output dates in your templates, [Carbon](https://carbon.nesbot.com) (the underlying package Statamic uses for handling dates) will automatically convert the date from UTC into your "display timezone".

You can configure the `display_timezone` in your `config/statamic/system.php` config file:

```php
/*  
|--------------------------------------------------------------------------  
| Timezone  
|--------------------------------------------------------------------------  
|  
| Statamic will use this timezone when displaying dates on the front-end.  
| You can use any timezone supported by PHP.  
|  
| https://www.php.net/manual/en/timezones.php  
|  
*/  
  
'display_timezone' => 'America/New_York',
```

However, as the timezone conversion only takes place when PHP converts the Carbon instance to a string, it means that any modifiers you're chaining on a date variable will be operating on the UTC date.

There are two ways you can workaround this:

1. You can add the  [`timezone`](https://statamic.dev.test/modifiers/timezone) modifier (or `tz` for short) to the start of your modifier "chain". It will convert the Carbon instance from UTC to your "display format":
  
  ```antlers
  {{ start_date | modify_date('+ day') | format('Y-m-d') }} {{# [tl! --] #}}
  {{ start_date | tz | modify_date('+ day') | format('Y-m-d') }} {{# [tl! ++] #}}
  ```

2. Alternatively, if you would rather not add the `timezone` modifier everywhere you're passing a date to a modifier, you may enable the `localize_dates_in_modifiers` config option in `config/statamic/system.php`.
   
	It will automatically convert dates to your configured "display timezone" *before* they get passed to any date modifiers.
	
	```php
	/*  
	|--------------------------------------------------------------------------  
	| Localize Dates in Modifiers?  
	|--------------------------------------------------------------------------  
	|  
	| Since Statamic stores dates in UTC, any modifiers you chain onto a date  
	| field will be working with the UTC value. If you'd prefer modifiers to  
	| always use your `display_timezone`, set this to `true`.  
	|  
	*/  
	  
	'localize_dates_in_modifiers' => true,
	```

## Custom Routes
If you're passing Carbon instances into templates yourself (eg. from a custom route), you should make sure they're all in UTC.

Under the hood, Statamic's `Localize` middleware uses Carbon's [`toStringFormat`](https://carbon.nesbot.com/docs/#api-formatting) setting to determine how dates are outputted when PHP calls `__toString()` on a Carbon instance.

You should ensure you're applying the `Localize` middleware to any custom routes in your application. If you're using `Route::statamic()` or the `statamic.web` middleware group, you'll already be using the `Localize` middleware.