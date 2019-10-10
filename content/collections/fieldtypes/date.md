---
title: Date
description: Helps you pick a date, but not get one.
overview: >
  Select and manage dates, times, and ranges.
screenshot: fieldtypes/date.png
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
      Optionally format the date string using Moment.js's [formatting options](https://momentjs.com/docs/#/displaying/format/).
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
      Choose between `single` or `range`. Range mode disable the time picker. Default: `single`.
      <figure>
        <img src="/img/fieldtypes/date-range.png" alt="Date fieldtype in range mode" width="301">
        <figcaption>Ranges are much simpler than two date fields.</figcaption>
      </figure>
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
        <img src="/img/fieldtypes/date-and-time.png" alt="Date fieldtype with time enabled" width="492">
        <figcaption>Now you can pick a time, too!</figcaption>
      </figure>
  -
    name: time_required
    type: boolean
    description: |
      Makes the time field visible and non-dismissible. Default: `false`.
id: 7dfba904-8a74-40e1-b507-51cd2b5f6123
---

## Overview

Date fields have highly configurable user interfaces. They can be as simple as a single date and/or time, or as fancy as a multi-month calendar with multi-day range picking. Be sure to experiment with the various [config options](#config-options) to create the best experience for your content authors.

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

```
// Nested variable
Event: {{ date:start }} through {{ date:end }}

// Tag pair
{{ date }}
Event: {{ start }} through {{ end }}
{{ /date }}
```

### Formatting Dates

You can format the output of your date fields with the [format modifier](/modifiers/format) and PHP's [date formatting options](https://www.php.net/manual/en/function.date.php).

```
{{ date format="Y" }} // 2019
{{ date format="Y-m-d" }} // 2019-10-10
{{ date format="l, F jS" }} // Sunday, January 21st
```

## Config Options

[carbon]: https://carbon.nesbot.com/docs/
