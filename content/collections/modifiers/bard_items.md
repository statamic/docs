---
id: 3c1a5985-1157-4287-801f-95a44b158c82
blueprint: modifiers
title: 'Bard Items'
modifier_types:
  - array
  - utility
---
Converts any Bard data to a flat array of ProseMirror nodes and marks. Bard data can be either:

* The raw value from a Bard field (a ProseMirror document), with or without sets
* One or more of the ProseMirror nodes returned from this modifier

```yaml
main_content:
  -
    type: paragraph
    content:
      -
        type: text
        text: "We're going to build a "
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: 'http://localhost/'
        text: 'simple personal'
      -
        type: text
        text: ' website for a fictitious young aspiring programmer named Kurt Logan'
  -
    type: paragraph
    content:
      -
        type: image
        attrs:
          src: 'asset::assets::donut.jpg'
      -
        type: text
        text: "Kurt always has and always will live in the 1980s and is very excited at the prospect of having his very own place in\_CYBERSPACE."
```

::tabs

::tab antlers
```antlers
{{ main_content | raw | bard_items }}
{{ main_content | raw | bard_items | where:type:image | first | bard_html }}
{{ links = main_content | raw | bard_items | where:type:link }}
{{ links }}
    {{ node | bard_text }} - {{ attrs:href }}
{{ /links }}
```
::tab blade
```blade
<?php
    Statamic::modify($bard_field_with_sets)->bardItems();
    Statamic::modify($bard_field_with_sets)->bardItems()->where('type:text')->first()->bardHtml();
    $links = Statamic::modify($bard_field_with_sets)->bardItems()->where('type:link')->fetch();
?>

@foreach ($links as $link)
	{{ Statamic::modify($link['node'])->bardText() }} - {{ $link['attrs']['href'] }}
@endforeach
```
::

```yaml
value:
  -
    type: paragraph
    content:
      -
        type: text
        text: "We're going to build a "
      -
        type: text
        marks:
          -
            type: link
            attrs:
              href: 'http://localhost/'
        text: simple personal
      -
        type: text
        text: ' website for a fictitious young aspiring programmer named Kurt Logan'
  -
    type: text
    text: "We're going to build a "
  -
    type: text
    marks:
      -
        type: link
        attrs:
          href: 'http://localhost/'
    text: simple personal
  -
    type: link
    attrs:
      href: 'http://localhost/'
    node:
      type: text
      marks:
        -
          type: link
          attrs:
            href: 'http://localhost/'
      text: simple personal
  -
    type: text
    text: ' website for a fictitious young aspiring programmer named Kurt Logan'
  -
    type: paragraph
    content:
      -
        type: image
        attrs:
          src: 'asset::assets::donut.jpg'
      -
        type: text
        text: "Kurt always has and always will live in the 1980s and is very excited at the prospect of having his very own place in\_CYBERSPACE."
  -
    type: image
    attrs:
      src: 'asset::assets::donut.jpg'
  -
    type: text
    text: "Kurt always has and always will live in the 1980s and is very excited at the prospect of having his very own place in\_CYBERSPACE."
```

```html
<img src="/assets/donut.jpg" alt="">
```

```
simple personal - http://localhost/
```