---
types:
  - markup
  - string
id: ee9e1c05-8b5d-47f9-b476-3d108a9c14af
---
Wraps a string with a given HTML tag. Has the nice benefit of returning null if there is no data, eliminating the need for simple `{{ if }}` wrappers.

```.language-yaml
title: As the World Turns
```

```
{{ title | wrap:h1 }}
```

```.language-output
<h1>As the World Turns</h1>
```

You may also use Emmet-style CSS classes to be added to the tag.

```
{{ title | wrap:h1.fast.furious }}
```

``` .language-output
<h1 class="fast furious">As the World Turns</h1>
```
