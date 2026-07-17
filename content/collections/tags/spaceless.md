---
title: Spaceless
id: 770a2167-bdb1-4c37-944e-af21a8a9343d
description: 'Strips the invisible gaps between HTML tags that your formatter keeps sneaking into your templates.'
intro: 'You formatted your Antlers nicely, and now there''s a mystery gap between two buttons that no amount of margin-hunting will explain. The `spaceless` tag hunts down whitespace between tags and removes it, without touching your actual words.'
---
## Overview

Prettier (and friends) love reformatting your Antlers templates with generous indentation and line breaks. Browsers do not share this love: multiple whitespace characters between inline elements collapse into a single visible space in the rendered page. Put two `inline-block` buttons on separate lines, and you get an ugly gap between them that isn't margin, isn't padding, and isn't your fault. It's a stray `\n`, dressed up as a space.

The `spaceless` tag strips whitespace-only gaps between tags in its rendered content, so your formatter can indent however it wants without leaving fingerprints in the DOM.

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

## What it actually does

- Removes whitespace that sits directly between two tags (`>   <` becomes `><`).
- Collapses whitespace _within_ text nodes down to a single space, rather than deleting it, so `Hello\nWorld` stays `Hello World` instead of becoming `HelloWorld`.
- Leaves the contents of `<script>`, `<style>`, `<pre>`, and `<textarea>` completely untouched, since whitespace in there is meaningful, not accidental.
- Ignores whitespace inside a tag itself — attributes and their quoted values are none of its business, and invisible to the browser anyway.

## A more elaborate example

Given:

```html
<div>
    <script>
    alert(1);
    </script>
</div>
```

`spaceless` tightens up the `div`'s edges but leaves the script's own formatting exactly as written:

::tabs
::tab antlers
```antlers
{{ spaceless }}
    <div>
        <script>
        alert(1);
        </script>
    </div>
{{ /spaceless }}
```
::tab blade
```blade
<s:spaceless>
    <div>
        <script>
        alert(1);
        </script>
    </div>
</s:spaceless>
```
::

```html
<div><script>
        alert(1);
        </script></div>
```

## When to use it

It's best suited to small, inline-heavy chunks where a stray space actually shows up on screen: buttons sitting side by side, badges, breadcrumb separators, nav items. It's not much use wrapped around a whole page body, where nobody's squinting at the gap between a `<header>` and a `<main>`.

If you want tidy output without babysitting this tag everywhere, wrap just the fussy inline bits rather than reaching for it as a blanket fix for the whole template.
