---
id: c5a7e328-3d6a-4866-970f-5a4e0061d606
blueprint: modifiers
modifier_types:
  - date
title: Timezone
---
Applies a timezone to a date value. Aliased as `tz`.

You may pass a [PHP timezone value](http://php.net/manual/en/timezones.php) to specify a timezone.

```yaml
when: 2015-01-27 11:00
```

::tabs

::tab antlers
```antlers
{{ when | format('r') }}
{{ when | timezone('Australia/Sydney') | format('r') }}
```
::tab blade
```blade
{{ Statamic::modify($when)->format('r') }}
{{ Statamic::modify($when)->timezone('Australia/Sydney')->format('r') }}
```
::

```html
Tue, 27 Jan 2015 11:00:00 -0500
Wed, 28 Jan 2015 03:00:00 +1100
```

Using no parameter will simply use the `display_timezone` configured in your `config/statamic/system.php` config file. This is useful if your date value already contains a timezone, and you want to output it in the display timezone.

```yaml
when: Tue, 27 Jan 2015 16:00:00 +0000  # Date in UTC
```

::tabs

::tab antlers
```antlers
{{ when | timezone | format('r') }}
```
::tab blade
```blade
{{ Statamic::modify($when)->timezone()->format('r') }}
```
::

```html
Tue, 27 Jan 2015 11:00:00 -0500  <!-- Assuming my system timezone is America/New_York -->
```
