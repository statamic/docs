---
title: "Glide:Batch"
description: Manipulates a whole batch of `<img>` tags
intro: Use `glide:batch` to manipulate a whole batch of `<img>` tags with [Glide](/tags/glide).
parameters:
  -
    name: glide parameters
    type: mixed
    description: |
      All of the manipulation parameters listed on the [Glide tag](/tags/glide#parameters).
id: 5173c6fb-8c28-4cb1-9d2e-b7c902f96308
---
## Overview

Wraps content containing `<img>` tags and each will be manipulated with your desired Glide parameters.

This tag is useful when uniformly resizing all images inside a chunk of HTML or the contents of Markdown or other fields. If you wrap the tag around Antlers variables, be sure to use **page scope:** `{{ page:content }}` instead of `{{ content }}`.

## Example

``` markdown
I went exploring today and here are some photos I took and I was too lazy to use an Asset fieldtype so here they all are plop ok

![Bears](/images/bears.jpg)
![Beets](/images/beets.jpg)
![Battlestar](/images/galactica.jpg)
```

```
{{ glide:batch width="600" height="400" fit="crop" }}
  {{ page:content }}
{{ /glide:batch }}
```

``` output
<p>I went exploring today and here are some photos I took and I was too lazy to use an Asset fieldtype so here they all are plop ok</p>

<img src="/img/assets/bears.jpg?w=600&h=400&fit=crop" title="Bears" />
<img src="/img/assets/beats.jpg?w=600&h=400&fit=crop" title="Beats" />
<img src="/img/assets/galactica.jpg?w=600&h=400&fit=crop" title="Battlestar" />
```
