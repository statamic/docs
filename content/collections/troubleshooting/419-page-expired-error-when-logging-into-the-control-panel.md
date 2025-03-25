---
id: 3faef3ae-8673-42ba-901b-a1d7eb3db4b7
blueprint: troubleshooting
title: '"419 Page Expired" error when logging into the Control Panel'
categories:
  - troubleshooting
template: page
---
There are a few common reasons why you might encounter a "419 Page Expired" error when attempting to login to the Control Panel.

## Database session driver
The most common reason you'll see this error is if you're using the [`database` session driver](https://laravel.com/docs/session#database).

The `user_id` column on the `sessions` table expects an integer value. However, because Statamic uses UUIDs for user IDs, the session row is saved incorrectly, causing the 419 error.

You can workaround this by changing the `user_id` column to a string/varchar:

```php
Schema::create('sessions', function (Blueprint $table) {
	$table->string('id')->primary();
	$table->foreignId('user_id')->nullable()->index(); // [tl! remove]
  	$table->string('user_id')->nullable()->index(); // [tl! add]
	$table->string('ip_address', 45)->nullable();
	$table->text('user_agent')->nullable();
	$table->longText('payload');
	$table->integer('last_activity')->index();
});
```

## Browser Autofill
Another potential cause for this issue might be interference by your browser's autocomplete, or an extension which provides similar functionality (like 1Password).

When it autocompletes your login details, it might also be changing the value of the hidden `_token` input, which is used for storing your [CSRF token](https://laravel.com/docs/master/csrf#main-content).

To rule this out, you could try disabling all browser extensions, or logging in to the Control Panel using a different browser.