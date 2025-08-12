---
title: SVG
description: 'Renders inline SVGs'
intro: |
  The SVG tag renders inline SVGs and lets you easily set attributes on the `<svg>` element.

parameters:
  -
    name: src
    type: string
    description: |
      The svg filename relative to root. The `.svg` extension is optional. Intelligently looks through (in this order):
      - `resources/svg`
      - `resources`
      - `public/svg`
      - `public`
  -
    name: sanitize
    type: boolean
    description: Determines whether the SVG should be sanitized before being output. Defaults to `true`.
  -
    name: allow_attrs
    type: array
    description: >
      Set an array of allowable attributes to bypass sanitization. Example: `allow_attrs="from|to"`.
  -
    name: '*'
    type: string
    description: >
      Any additional parameter will be set as attributes on the `<svg>` element. For example `class="fill-current"` will set `<svg class="fill-current" ...>`.
id: 4f54ed6a-4a80-4ee4-899b-cbae5cd3b73c
---
## Overview

Working with inline SVGs gives you the ability to cache them along with your markup and style them with CSS. It's one of the best reasons to work with SVG images.

To make dev life easier, this tag collapses whitespace automatically and can set attributes like `class` or `height/width` for you. It looks in `resources` and `public` automatically to keep your [src](#parameters) parameter nice and short, like a summer haircut.

## Example

::tabs

::tab antlers
```antlers
// Using resources/svg/circle.svg
{{ svg src="circle" class="fill-current text-teal" }}

// Using public/img/icons/square
{{ svg src="img/icons/square" class="fill-current text-mint" }}

// Using a variable `promo_graphic` (defined in your blueprint)
{{ svg :src="promo_graphic" class="fill-current text-orange" }}
```
::tab blade
```blade
// Using resources/svg/circle.svg
<s:svg src="circle" class="fill-current text-teal" />

// Using public/img/icons/square
<s:svg src="img/icons/square" class="fill-current text-mint" />

// Using a variable `promo_graphic` (defined in your blueprint)
<s:svg :src="$promo_graphic" class="fill-current text-orange" />
```
::

```html
<svg class="fill-current text-teal" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
  <circle cx="50" cy="50" r="50"/>
</svg>

<svg class="fill-current text-mint" viewBox="0 0 220 100" xmlns="http://www.w3.org/2000/svg">
  <rect width="100" height="100" />
</svg>
```

## Sanitization

All SVGs are sanitized on upload into the control panel _and_ on output for to pretect your site from malicious code or other forms of potential compromise. You can [learn more about what's possible](https://www.cloudflare.com/threat-intelligence/research/report/svgs-the-hackers-canvas/) for hackers to attempt with SVGs.

However, this sanitization may prove to be more aggressive than is beneficial for you. If you are complete control of your uploads and trust your control panel users, you can disable sanitzation on upload in your assets config file like this:

``` php
// config/statamic/assets.php
'svg_sanitization_on_upload' => false,
```

Combine that setting with the `sanitize="false"` or `allow_attrs` parameters documented below to allow those additional SVG attributes and elements to render on your frontend.

## Additional Reading

- [SVG Properties and CSS](https://css-tricks.com/svg-properties-and-css/)
- Tailwind has numerous SVG helpers, like [fill](https://tailwindcss.com/docs/fill) and [stroke](https://tailwindcss.com/docs/stroke), and a video on [working with SVG Icons](https://tailwindcss.com/course/working-with-svg-icons)
