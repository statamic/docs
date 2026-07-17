---
title: Spaceless
id: 770a2167-bdb1-4c37-944e-af21a8a9343d
description: 'Strips the invisible gaps between HTML tags that your formatter keeps sneaking into your templates.'
intro: 'You formatted your Antlers nicely, and now there''s a mystery gap between two buttons that no amount of margin-hunting will explain. The `spaceless` tag hunts down whitespace between tags and removes it, without touching your actual words.'
---
## Overview

Prettier and friends love breaking markup onto new lines, one tag per line, neatly indented. Browsers turn that line break into a visible gap between inline elements. `spaceless` strips whitespace-only gaps between tags in its rendered content, so your formatter can keep breaking lines without leaving fingerprints in the DOM.

::tabs
::tab antlers
```antlers
{{ spaceless }}
    <ul>
        <li>One</li>
        <li>Two</li>
    </ul>
{{ /spaceless }}
```
::tab blade
```blade
<s:spaceless>
    <ul>
        <li>One</li>
        <li>Two</li>
    </ul>
</s:spaceless>
```
::

```html
<ul><li>One</li><li>Two</li></ul>
```

## What it does

- Removes whitespace that sits directly between two tags (`>   <` becomes `><`).
- Collapses whitespace within text down to a single space rather than deleting it, so `Hello\nWorld` stays `Hello World`.
- Leaves whitespace around an inline tag inside prose alone, so a link mid-sentence doesn't glue to its neighboring words.
- Leaves `<script>`, `<style>`, `<pre>`, and `<textarea>` completely untouched, since whitespace in there is meaningful.

## When to use it

Small, inline-heavy chunks where a stray space actually shows up on screen: buttons sitting side by side, badges, breadcrumb separators, nav items. Not much use wrapped around a whole page body, where nobody's squinting at the gap between a `<header>` and a `<main>`.
