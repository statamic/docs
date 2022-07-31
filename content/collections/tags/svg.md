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
    name: '*'
    type: string
    description: >
      Any additional parameter will be set as attributes on the `<svg>` element. For example `class="fill-current"` will set `<svg class="fill-current" ...>`.
stage: 4
id: 4f54ed6a-4a80-4ee4-899b-cbae5cd3b73c
---
## Overview

Working with inline SVGs gives you the ability to cache them along with your markup and style them with CSS. It's one of the best reasons to work with SVG images.

To make dev life easier, this tag collapses whitespace automatically and can set attributes like `class` or `height/width` for you. It looks in `resources` and `public` automatically to keep your [src](#parameters) parameter nice and short, like a summer haircut.

## Example

```
// Using resources/svg/circle.svg
{{ svg src="circle" class="fill-current text-teal" }}

// Using public/img/icons/square
{{ svg src="img/icons/square" class="fill-current text-mint" }}

// Using a variable `promo_graphic` (defined in your blueprint)
{{ svg :src="promo_graphic" class="fill-current text-orange" }}
```

```html
<svg class="fill-current text-teal" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
  <circle cx="50" cy="50" r="50"/>
</svg>

<svg class="fill-current text-mint" viewBox="0 0 220 100" xmlns="http://www.w3.org/2000/svg">
  <rect width="100" height="100" />
</svg>
```

## Additional Reading

- [SVG Properties and CSS](https://css-tricks.com/svg-properties-and-css/)
- Tailwind has numerous SVG helpers, like [fill](https://tailwindcss.com/docs/fill) and [stroke](https://tailwindcss.com/docs/stroke), and a video on [working with SVG Icons](https://tailwindcss.com/course/working-with-svg-icons)
