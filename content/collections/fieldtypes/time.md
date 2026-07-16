---
title: Time
description: A timepicker. It lets you pick a time.
intro: The original time field from the set of Kiefer Sutherland's hit drama "24". It's a simple timepicker that operates in 24-hour mode and supports keyboard `up` and `down` controls.
screenshot: fieldtypes/screenshots/v6/time.webp
screenshot_dark: fieldtypes/screenshots/v6/time-dark.webp
id: ccfbaf71-7823-4f71-a375-e874035f80ca
options:
  -
    name: augment_format
    type: string
    description: |
      A PHP date format that'll be used when outputting this field in your templates.
---

:::warning Psst!
This fieldtype saves "wall clock time" – what you'd see if you looked at a clock on the wall. There's no timezone or date associated with it.

You probably *don't* want to try using any date modifiers with this – except for [format_time](/modifiers/format_time).

You may want to consider using a [date fieldtype](/fieldtypes/date) with the time enabled.
:::
