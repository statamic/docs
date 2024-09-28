---
title: Date
description: Helps you pick a date, but not get one.
intro: >
  Work with dates, times, and ranges with a variety of user interface options that make you really enjoy basically just picking numbers from a table.
screenshot: fieldtypes/screenshots/date.png
options:
  -
    name: columns
    type: integer
    description: |
     Show multiple months at one time, in columns and rows. Default: `1`.
  -
    name: earliest_date
    type: string
    description: |
      Set the earliest selectable date in `YYYY-MM-DD` format. Default: `1900-01-01`.
  -
    name: format
    type: string
    description: |
      How the date should be stored, using the [PHP date format](https://www.php.net/manual/en/datetime.format.php)
  -
    name: full_width
    type: boolean
    description: |
      Enable to stretch the calendar out like Stretch Armstrong, using the maximum amount of available horizontal space. Default: `false`.
  -
    name: inline
    type: boolean
    description: |
      Always show the calendar instead of the text input and dropdown UI. Default: `false`.
  -
    name: mode
    type: string
    description: |
      Choose between `single` or `range`. Range mode disables the time picker. Default: `single`.
  -
    name: rows
    type: integer
    description: |
     Show multiple months at one time, in columns and rows. Default: `1`.
  -
    name: time_enabled
    type: boolean
    description: |
      Enable/disable the timepicker. Default: `false`.
      <figure>
        <img src="/img/fieldtypes/screenshots/date-and-time.png" alt="Date fieldtype with time enabled" width="492">
        <figcaption>Now you can pick a time, too!</figcaption>
      </figure>
  -
    name: time_required
    type: boolean
    description: |
      Makes the time field visible and non-dismissible. Default: `false`.
stage: 2
id: 7dfba904-8a74-40e1-b507-51cd2b5f6123
---

## Overview

Date fields have highly configurable user interfaces. They can be as simple as a single date and/or time, or as fancy as a multi-month calendar with multi-day range picking. Be sure to experiment with the various config [options](#options) to create the best experience for your content authors.

## Data Structure

Single dates are stored as a date/timestring. Ranges are stored as an array with a `start` and `end` key.

``` yaml
date: 1983-10-01
date_with_time: 1983-10-01 12:00:00
date_range:
  start: 2019-11-18
  end: 2019-11-22
```

## Templating

Date fields are [augmented](/augmentation) to return a [Carbon instance][carbon]. When used as a string they will return a pre-formatting output that uses your `config.date` format setting. By default that'll look like `January 1, 2020`.

### Date Ranges

Ranges have nested `start` and `end` variables, so you can access them like this:

::tabs

::tab antlers
```antlers
// Nested variable
Event: {{ date:start }} through {{ date:end }}

// Tag pair
{{ date }}
Event: {{ start }} through {{ end }}
{{ /date }}
```

::tab blade

```blade
Event: {{ $date_range['start'] }} through {{ $date_range['end'] }}
```

::

<figure>
  <img src="/img/fieldtypes/screenshots/date-range.png" alt="Date fieldtype in range mode" width="301">
  <figcaption>Ranges are much simpler than two date fields.</figcaption>
</figure>

### Formatting Dates

You can format the output of your date fields with the [format modifier](/modifiers/format) and PHP's [date formatting options](https://www.php.net/manual/en/function.date.php).

::tabs

::tab antlers
```antlers
{{ date format="Y" }} // 2019
{{ date format="Y-m-d" }} // 2019-10-10
{{ date format="l, F jS" }} // Sunday, January 21st
```

::tab blade

When using Blade, you may also call the `->format` method on Carbon instances.

```blade
{{-- Using Modifiers --}}
{{ Statamic::modify($date)->format('Y') }} // 2019
{{ Statamic::modify($date)->format('Y-m-d') }} // 2019-10-10
{{ Statamic::modify($date)->format('l, F jS') }} // Sunday, January 21st

{{-- Using Carbon methods --}}
{{ $date->format('Y') }} // 2019
{{ $date->format('Y-m-d') }} // 2019-10-10
{{ $date->format('l, F jS') }} // Sunday, January 21st
```

::

### Formatting localized Dates

You can format localized dates with the [iso modifier](/modifiers/iso_format) and [ISO formatting options](https://carbon.nesbot.com/docs/#api-localization). This use Carbon's inner translations rather than language packages you need to install on every machine where you deploy your application.

::tabs

::tab antlers
```antlers
{{ date iso_format="YYYY" }} // 2019
{{ date iso_format="YYYY-MM-DD" }} // 2019-10-10
{{ date iso_format="dddd, MMMM Do" }} // Sunday, January 21st
```

::tab blade

When using Blade, you may also call the `->isoFormat` method on Carbon instances.

```blade
{{-- Using Modifiers --}}
{{ Statamic::modify($date)->isoFormat('YYYY') }} // 2019
{{ Statamic::modify($date)->isoFormat('YYYY-MM-DD') }} // 2019-10-10
{{ Statamic::modify($date)->isoFormat('dddd, MMMM Do') }} // Sunday, January 21st

{{-- Using Carbon methods --}}
{{ $date->isoFormat('YYYY') }} // 2019
{{ $date->isoFormat('YYYY-MM-DD') }} // 2019-10-10
{{ $date->isoFormat('dddd, MMMM Do') }} // Sunday, January 21st

```

::



[carbon]: https://carbon.nesbot.com/docs/
