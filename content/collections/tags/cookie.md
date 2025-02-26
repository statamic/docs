---
title: Cookie
description: 'Get, set, check, and forget cookies.'
intro: 'Cookies provide a client-side way to store information about the user across requests. The cookie tag will let you get, set, and forget cookie data.'
is_parent_tag: false
id: c15836c2-808d-4260-9d01-e5a569da5b7a
---
## Retrieving Cookie Data

You can use `{{ cookie }}` as a tag pair to access any cookie data that has been set.

::tabs

::tab antlers
```antlers
{{ cookie }}
    {{ oreo }}
{{ /cookie }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:cookie>
  {{ $oreo ?? '' }}
</s:cookie>

{{-- Using the Cookie facade --}}
{{ Cookie::get('oreo') }}
```
::

```.output
Yum yum yum.
```

You can also retrieve single variables with a single tag syntax.

::tabs

::tab antlers
```antlers
{{ cookie:oreo }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:cookie:oreo />

{{-- Using the Cookie facade --}}
{{ Cookie::get('oreo') }}
```
::

## Checking

You can check if a cookie exists with [cookie:has](/tags/session-has).

::tabs

::tab antlers
```antlers
{{ if {cookie:has key="has_voted"} === true }}
  You already voted. Thank you!
{{ /if }}
```
::tab blade
```blade
{{-- Using the Cookie facade --}}
@if (Cookie::has('has_voted') === true)
  You already voted. Thank you!
@endif
```
::

## Aliasing

If you need extra markup around your cookie data, you can _alias_ a new child array variable.

::tabs

::tab antlers
```antlers
{{ cookie as="snack" }}
  {{ snack }}
    {{ message }}
  {{ /snack }}
{{ /cookie }}
```
::tab blade
```blade
{{-- Retrieving the message using the Cookie facade --}}
{{ Cookie::get('message') }}

{{-- Aliasing using Antlers Blade Components --}}
<s:cookie as="snack">
  {{ $snack['oreo'] ?? '' }}
</s:cookie>
```
::

## Setting

You can set a cookie with `cookie:set`:

::tabs

::tab antlers
```antlers
{{ cookie:set my_key="my_value" }}
```
::tab blade
```blade
{{-- Using Antler Blade Components --}}
<s:cookie:set my_key="my_value" />

{{-- Using the cookie helper --}}
<?php
  cookie()->queue(cookie('my_key', 'my_value'));
?>
```
::

You can optionally set a number of minutes the cookie is valid for (60 by default):

::tabs

::tab antlers
```antlers
{{ cookie:set my_key="my_value" minutes="3600" }}
```
::tab blade
```blade
{{-- Using Antler Blade Components --}}
<s:cookie:set
  my_key="my_value"
  minutes="3600"
/>

{{-- Using the cookie helper --}}
<?php
  cookie()->queue(cookie('my_key', 'my_value', 3600));
?>
```
::

You can set multiple cookies at once and reference interpolated data (references to variables).

::tabs

::tab antlers
```antlers
{{ cookie:set likes="hats" :visited="url" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:cookie:set
  likes="hats"
  :visited="$url"
/>

{{-- Using the cookie helper --}}
<?php
  cookie()->queue(cookie('likes', 'hats'));
  cookie()->queue(cookie('visited', $url));
?>
```
::

:::tip
When you set a cookie, it will only be available on the _next_ request.
:::

## Forgetting

You can remove cookies by passing the names of the variables into the `keys` parameter. Pass multiple keys by delimiting them with a pipe.

::tabs

::tab antlers
```antlers
{{ cookie:forget keys="likes|referral" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:cookie:forget
  keys="likes|referral"
/>

{{-- Using the Cookie helper --}}
<?php
  cookie()->queue(cookie()->forget('likes'));
  cookie()->queue(cookie()->forget('referral'));
?>
```
::

## Accessing Cookies in JavaScript

By default, in Laravel, cookies are encrypted so you will not be able to access the values of any data you set outside of PHP. To exclude specific cookies from encryption follow the steps below:

### Laravel 10

To prevent encryption you need to add an exception to the `$except` array in your `app/Http/Middleware/EncryptCookies.php` file.

```php
/**
 * The names of the cookies that should not be encrypted.
 *
 * @var array
 */
protected $except = [
    'cookie_name',
];
```

### Laravel 11 and above

To prevent encryption you need to use the `encryptCookies` method in your application's `bootstrap/app.php` file:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->encryptCookies(except: [
        'cookie_name',
    ]);
})
```
