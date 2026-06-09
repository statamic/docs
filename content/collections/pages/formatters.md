---
title: Formatters
intro: |
  Locale-aware formatters for dates and numbers in the Control Panel, built on top of the browser's `Intl` APIs.
id: 4bd202d5-6ef2-4fb3-9e90-aed0d0183071
---
Statamic ships two JavaScript formatters for rendering dates and numbers in the user's locale. They're thin wrappers around the browser's [`Intl.DateTimeFormat`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat) and [`Intl.NumberFormat`](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/NumberFormat) APIs with a few Statamic-flavored presets and a shared locale.

```js
import { dateFormatter, numberFormatter } from '@statamic/cms/api';
```

:::tip
Both formatters share the same default locale. Calling `setDefaultLocale()` on one is reflected in the other.
:::

## Date Formatter

The `dateFormatter` renders dates using the browser's `Intl.DateTimeFormat` with a handful of built-in presets.

### Presets

| Preset | Description |
|---|---|
| `datetime` | Year, month, day, hour, minute (default) |
| `date` | Year, month, day |
| `time` | Short time style |

### Formatting dates

```js
import { dateFormatter } from '@statamic/cms/api';

dateFormatter.format('2026-03-26T20:24:21');
// en-us: 3/26/2026, 8:24 PM
// de:    26.3.2026, 20:24

dateFormatter.format('2026-03-26', 'date');
// en-us: 3/26/2026

dateFormatter.format('2026-03-26T20:24:21', 'time');
// en-us: 8:24 PM
```

You can pass any [`Intl.DateTimeFormat` options](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat/DateTimeFormat#options) object instead of a preset name:

```js
dateFormatter.format('2026-03-26', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
});
// March 26, 2026
```

### Overriding preset options

To start from a preset and tweak only a few fields, pass an options object with a `preset` key alongside any other `Intl.DateTimeFormat` options. The overrides are merged on top of the preset.

```js
dateFormatter.format('2026-03-26T20:24:21', {
    preset: 'datetime',
    timeZone: 'Australia/Sydney',
});

dateFormatter.format('2026-03-26T20:24:21', {
    preset: 'datetime',
    month: 'short',
});
```

### Relative dates

Pass `relative: true` (or a specificity) to output a humanized relative string powered by `Intl.RelativeTimeFormat`.

```js
dateFormatter.format(someDate, { relative: true });         // "3 months ago"
dateFormatter.format(someDate, { relative: 'day' });        // caps out at days
dateFormatter.format(someDate, { relative: 'hour' });       // caps out at hours
```

Valid specificities are `minute`, `hour`, `day`, `week`, `month`, and `year` (the default when `true`). When the date falls outside your specificity, it falls back to `datetime` — pass `fallback` to override:

```js
dateFormatter.format(someDate, {
    relative: 'day',
    fallback: 'date',
});
```

### Static usage

```js
import DateFormatter from '@statamic/cms/components/DateFormatter.js';

DateFormatter.format('2026-03-26', 'date');
```

## Number Formatter

The `numberFormatter` renders numbers and numeric ranges using `Intl.NumberFormat`.

### Presets

| Preset | Description |
|---|---|
| `decimal` | Standard decimal formatting (default) |
| `percent` | Multiplies by 100 and appends `%` |

### Formatting numbers

```js
import { numberFormatter } from '@statamic/cms/api';

numberFormatter.format(123456789.10);
// en: 123,456,789.1
// de: 123.456.789,1

numberFormatter.format(0.25, 'percent');
// en: 25%

numberFormatter.format(1234.5, {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
});
// en: 1,234.50
```

Any [`Intl.NumberFormat` options](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/NumberFormat/NumberFormat#options) are accepted.

### Formatting ranges

```js
numberFormatter.formatRange(1234, 5678);
// en:    1,234–5,678
// ja-jp: 1,234～5,678

numberFormatter.formatRange(0.1, 0.2, 'percent');
// en: 10%–20%
// de: 10–20 %
```

### Static usage

```js
import NumberFormatter from '@statamic/cms/components/NumberFormatter.js';

NumberFormatter.format(1234.5, 'decimal');
NumberFormatter.formatRange(1, 10);
```

## Locale

Both formatters default to the user's browser locale (via `Intl.DateTimeFormat().resolvedOptions().locale`). The default locale is shared between them, so changing it on one instance affects the other.

### Reading the current locale

```js
dateFormatter.locale;    // e.g. "en-us"
numberFormatter.locale;  // same value
```

### Setting the default locale

```js
import { dateFormatter, numberFormatter } from '@statamic/cms/api';

numberFormatter.setDefaultLocale('de');

dateFormatter.format('2026-03-26');   // 26.3.2026, ...
numberFormatter.format(1234.5);       // 1.234,5
```

Or using the static accessor:

```js
import DateFormatter from '@statamic/cms/components/DateFormatter.js';

DateFormatter.defaultLocale = 'de';
DateFormatter.defaultLocale;  // "de"
```

### Temporarily switching locales

Use `withLocale` to run a callback under a different locale without leaking the change. The previous locale is always restored, even if the callback throws.

```js
numberFormatter.withLocale('de', (formatter) => {
    return formatter.format(1234.567, 'decimal'); // 1.234,567
});

// Default locale is unchanged here.
```
