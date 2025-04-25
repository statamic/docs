---
id: 756d23b4-209c-457c-b9f5-d69347bbe8fe
blueprint: modifiers
modifier_types:
  - date
  - string
title: Format
---
Given a date string, or anything that sort of looks like a date string, `format` will convert it to a [Carbon][carbon] instance and allow you to format it with PHP's [datetime format][datetime] variables.

```yaml
event_date: April 15 2016
```

::tabs

::tab antlers
```antlers
{{ event_date | format('Y-m-d') }}
```
::tab blade
```blade
{{ Statamic::modify($event_date)->format('Y-m-d') }}
```
::

```html
2016-04-15
```

:::warning
By default, when using a modifier on a date variable, it will be operating on the UTC date rather than the localized date.

Please refer to our [Timezones](/tips/timezones) guide for more information.
:::

## Parameters

### Day

| Character | Description | Example |
| --------- | ----------- | -------------- |
| `d` | Day of the month, 2 digits with leading zeros | `01` to `31`  |
| `D` | A textual representation of a day, three letters  | `Mon` to `Sun` |
| `j` | Day of the month without leading zeros  | `1` to `31` |
| `l` | A full textual representation of the day of the week  | `Sunday` to `Saturday`|
| `N` | ISO 8601 numeric representation of the day of the week  | `1` (for Monday) to `7` (for Sunday) |
| `S` | English ordinal suffix for the day of the month, 2 characters | `st`, `nd`, `rd` or `th`. Works well with `j` |
| `w` | Numeric representation of the day of the week | `0` (for Sunday) to `6` (for Saturday) |
| `z` | The day of the year (starting from 0) | `0` to `365` |

### Week
| Character | Description | Example |
| --------- | ----------- | -------------- |
| `W`  | ISO 8601 week number of year, weeks starting on Monday  | `42` (the 42nd week in the year) |

### Month
| Value | Description | Example |
| --------- | ----------- | -------------- |
| `F`  | A full textual representation of a month, such as January or March  | `January` to `December`  |
| `m`  | Numeric representation of a month, with leading zeros | `01` to `12` |
| `M`  | A short textual representation of a month, three letters  | `Jan` to `Dec` |
| `n`  | Numeric representation of a month, without leading zeros  | `1` to `12`  |
| `t`  | Number of days in the given month | `28` to `31` |

### Year
| Value | Description | Example |
| --------- | ----------- | -------------- |
| `L`  | Whether it's a leap year  | `1` if it is a leap year, `0` otherwise.  |
| `o`  | ISO 8601 week-numbering year. | `1999` or `2003` |
| `Y`  | A full numeric representation of a year, at least 4 digits, with `-` for years BCE.| `-0055`, `0787`, `1999`, `2003` |
| `y`  | A two digit representation of a year  | `99` or `03`  |

### Time
| Value | Description | Example |
| --------- | ----------- | -------------- |
| `a`  | Lowercase Ante meridiem and Post meridiem | `am` or `pm`  |
| `A`  | Uppercase Ante meridiem and Post meridiem | `AM` or `PM`  |
| `B`  | Swatch Internet time (it's coming back, just you wait)  | `000` to `999` |
| `g`  | 12-hour format of an hour without leading zeros | `1` to `12`  |
| `G`  | 24-hour format of an hour without leading zeros | `0` to `23`  |
| `h`  | 12-hour format of an hour with leading zeros  | `01` to `12` |
| `H`  | 24-hour format of an hour with leading zeros  | `00` to `23` |
| `i`  | Minutes with leading zeros  | `00` to `59`  |
| `s`  | Seconds with leading zeros  | `00` to `59` |
| `u`  | Microseconds. | `654321` |
| `v`  | Milliseconds. Same note applies as for `u`.| `654`  |

### Timezone
| Value | Description | Example |
| --------- | ----------- | -------------- |
| `e` | Timezone identifier | `UTC`, `GMT`, `Atlantic/Azores` |
| `I`  | Whether or not the date is in daylight saving time | `1` if Daylight Saving Time, `0` otherwise. |
| `O` | Difference to Greenwich time (GMT) without colon between hours and minutes | `+0200` |
| `P` | Difference to Greenwich time (GMT) with colon between hours and minutes | `+02:00`  |
| `p` | The same as `P`, but returns `Z` instead of `+00:00` | `+02:00` |
| `T` | Timezone abbreviation, if known; otherwise the GMT offset.  | `EST`, `MDT`, `+05`  |
| `Z` | Timezone offset in seconds. The offset for timezones west of UTC is always negative, and for those east of UTC is always positive. | `-43200` to `50400`  |

### Full Date/Time

| Value | Description | Example |
| --------- | ----------- | -------------- |
| `c` | ISO 8601 date | 2004-02-12T15:19:21+00:00 |
| `r` | [RFC 2822](http://www.faqs.org/rfcs/rfc2822) or [RFC 5322](http://www.faqs.org/rfcs/rfc5322) formatted date | `Thu, 21 Dec 2000 16:01:07 +0200`  |

[carbon]: http://carbon.nesbot.com
[datetime]: https://www.php.net/manual/en/datetime.format.php
