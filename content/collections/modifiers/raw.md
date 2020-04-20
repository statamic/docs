---
types:
  - string
  - array
  - utility
id: e100a366-b69c-4d59-bec7-eac18c0b286b
---
Provides the unaugmented data, as it exists in the data file.

For example if you had a Bard field, `description`,  that rendered HTML, the `raw` data might look like:

```.language-yaml
description:
  -
    type: paragraph
    content:
      -
        type: text
        text: 'This is the first paragraph'
  -
    type: paragraph
    content:
      -
        type: text
        text: 'The second paragraph'

```

Template example:
```
{{ description raw="true" }}
  Type is {{ type }} and content is {{ content }}
{{ /description }}
```