---
id: 9840b1ab-4576-4cc9-9b83-9226d069807d
blueprint: modifiers
modifier_types:
  - string
  - array
title: Attribute
---

When you're writing partials, you might find yourself passing variables that will ultimately just be used in HTML attributes, like this:

```antlers
<input
    type="text"
    {{ if name }}name="{{ name }}"{{ /if }}
    {{ if class }}class="{{ class }}"{{ /if }}
    {{ if mandatory }}required{{ /if }}
/>
```

You can simplify this using the `attribute` modifier:

```yaml
name: first_name
class: text-sm font-mono text-gray-900
mandatory: true
```

```antlers
<input
    type="text"
    {{ name | attribute:name }}
    {{ class | attribute:class }}
    {{ mandatory | attribute:required }}
/>
```

```html
<input
    type="text"
    name="first_name"
    class="text-sm font-mono text-gray-900"
    required
/>
```

The `attribute` modifier supports passing booleans, *some* objects, arrays, integers, floats and strings.
