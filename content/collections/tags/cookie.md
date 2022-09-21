---
title: Cookie
description: 'Get, set, check, and forget cookies.'
intro: 'Cookies provide a client-side way to store information about the user across requests. The cookie tag will let you get, set, and forget cookie data.'
is_parent_tag: false
id: c15836c2-808d-4260-9d01-e5a569da5b7a
---
## Retrieving Cookie Data

You can use `{{ cookie }}` as a tag pair to access any cookie data that has been set.

```
{{ cookie }}
    {{ oreo }}
{{ /cookie }}
```

```.output
Yum yum yum.
```

You can also retrieve single variables with a single tag syntax.

```
{{ cookie:oreo }}
```

## Checking

You can check if a cookie exists with [cookie:has](/tags/session-has).

```
{{ if {cookie:has key="has_voted"} === true }}
  You already voted. Thank you!
{{ /if }}
```

## Aliasing

If you need extra markup around your cookie data, you can _alias_ a new child array variable.

```
{{ cookie as="snack" }}
  {{ snack }}
    {{ message }}
  {{ /snack }}
{{ /cookie }}
```

## Setting

You can set a cookie with `cookie:set`:

```
{{ cookie:set my_key="my_value" }}
```

You can optionally set a number of minutes the cookie is valid for (60 by default):

```
{{ cookie:set my_key="my_value" minutes="3600" }}
```

You can set multiple cookies at once and reference interpolated data (references to variables).

```
{{ cookie:set likes="hats" :visited="url" }}
```

:::tip
When you set a cookie, it will only be available on the _next_ request.
:::

## Forgetting

You can remove cookies by passing the names of the variables into the `keys` parameter. Pass multiple keys by delimiting them with a pipe.

```
{{ cookie:forget keys="likes|referral" }}
```

## Accessing Cookies in JavaScript

By default, in Laravel, cookies are encrypted so you will not be able to access the values of any data you set outside of PHP.

To prevent encryption you need to add an exception to the `$except` array in your `app/Http/Middleware/EncryptCookies.php` file.
