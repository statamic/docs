---
title: Batch
overview: Convert a batch of image URLs to their Glide counterparts.
parameters:
  -
    name: glide parameters
    type: mixed
    description: |
      All of the API manipulation parameters listed on the [Glide tag][tag].
      [tag]: /tags/glide#parameters
id: 5173c6fb-8c28-4cb1-9d2e-b7c902f96308
---
## Usage
This is a tag pair that wraps content containing `<img />` tags. Each image tag's `src` attribute will be converted to Glide URLs.

A common use case for this tag would be to resize all raw image assets inserted into a Markdown or Redactor field.

## Example

We have a markdown field with some images sprinkled througout.

```.language-markdown
![Bears](/assets/bears.jpg)
![Beets](/assets/beets.jpg)
![Battlestar](/assets/galactica.jpg)
```

```
{{ glide:batch width="300" height="200" fit="crop" }}
  {{ content | markdown }}
{{ /glide:batch }}
```

``` .language-output
<img src="/img/assets/bears.jpg?w=300&h=200&fit=crop" title="Bears" />
<img src="/img/assets/beats.jpg?w=300&h=200&fit=crop" title="Beats" />
<img src="/img/assets/galactica.jpg?w=300&h=200&fit=crop" title="Battlestar" />
```

[glide_tag]: /tags/glide
