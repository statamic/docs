---
title: 'Session:Dump'
description: 'Peek into the user session for debugging purposes.'
intro: The contents of the user session can be dumped to the browser. You never know when you need to peek inside the black box.
stage: 5
id: d1ef36ac-7d21-40b2-a7fc-b53a0be3c79c
---
## Example

::tabs

::tab antlers
```antlers
{{ session:dump }}
```
::tab blade
```blade
{{-- Using session() helper and PHP --}}
@php(dump(session()->all()))

{{-- Using Antlers Blade Components --}}
<s:session:dump />
```
::

<figure>
    <img src="/img/session-dump.png" alt="Screenshot of the output of a session:dump tag.">
    <figcaption>If you're lucky, your dump can look like this.</figcaption>
</figure>
