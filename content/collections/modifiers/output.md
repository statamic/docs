---
id: b5409a41-cc62-4ca1-bb8a-f6700b2c8c29
blueprint: modifiers
title: Output
modifier_types:
  - asset
  - utility
---
Given the URL to an Asset file, returns the string output of an Asset file's contents. This is primarily useful for rendering inline SVGs, but could also be used to display a lot of gibberish to your users if you're into that kind of thing.

```yaml
icon: /img/icons/heart.svg
```

::tabs

::tab antlers
```antlers
{{ icon | output }}
```
::tab blade
```blade
{!! Statamic::modify($icon)->output() !!}
```
::

```html
<svg width="52px" height="50px" viewBox="0 0 52 50" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Icons" transform="translate(-965.000000, -2883.000000)" fill="#1A1718">
            <g id="Heart" transform="translate(965.000000, 2883.000000)">
                <path d="M51.912,15.338 C51.153,6.983 45.24,0.923 37.841,0.923 C32.911,0.923 28.396,3.576 25.856,7.828 C23.34,3.522 19.011,0.922 14.159,0.922 C6.76,0.922 0.847,6.982 0.088,15.337 C0.028,15.706 -0.218,17.647 0.53,20.814 C1.608,25.383 4.099,29.537 7.729,32.827 L25.845,49.267 L44.271,32.829 C47.901,29.538 50.392,25.384 51.47,20.815 C52.218,17.649 51.972,15.707 51.912,15.338 L51.912,15.338 Z M16,9 C11.589,9 8,12.589 8,17 C8,17.553 7.553,18 7,18 C6.447,18 6,17.553 6,17 C6,11.486 10.486,7 16,7 C16.553,7 17,7.447 17,8 C17,8.553 16.553,9 16,9 L16,9 Z"></path>
            </g>
        </g>
    </g>
</svg>
```
