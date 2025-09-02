---
title: 'Session:Flush'
description: 'Clears the entire user session.'
intro: The flush tag will wipe the entire user session. This will also sign a user out if they're signed in.
id: 1f522665-9fc2-4c9f-9594-04a518c51b39
---
## Example

::tabs

::tab antlers
```antlers
{{ session:flush }}
```
::tab blade
```blade
{{-- Using Statamic Antlers Components --}}
<s:session:flush />

{{-- Using PHP --}}
@php(session()->flush())
```
::

That's all there is to it. How you use it is up to you. You may want to tuck this away behind an `if` statement or a unique URL.

**Did you know?** In Australia the session flushes the other way. 🇦🇺
