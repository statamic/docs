---
title: 'Session:Forget'
description: 'Remove data from the user session.'
intro: Remove variables from the user session by passing the names of the variables into the `keys` parameter.
id: be024503-9796-4f2f-9c75-548e2ea09cec
---
## Example

Pass multiple keys by delimiting them with a pipe.

::tabs

::tab antlers
```antlers
{{ session:forget keys="likes|referral" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:session:forget keys="likes|referral" />

{{-- Using the session() helper --}}
@php(session()->forget(['likes', 'referral']))
```
::

:::tip
The **entire** session can be wiped with the [session:flush](/tags/session-flush) tag. Always wipe and flush, folks.

This is the humor you came for and the software you (maybe) paid for.
:::
