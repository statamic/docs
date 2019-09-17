---
title: List
description: Manage simple lists with the help of a very keyboard-friendly interface.
overview: >
  Create YAML lists with an intuitive interface. It has full keyboard controls
  so you can use `up` to go up, `down` to go down, drag and drop to rearrange the order, and double-click to edit any item.
image: /assets/fieldtypes/list.png
id: bd079cba-c5d2-475d-ae82-57874818858e
---
## Templating {#templating}

The example above would have the following data which can be looped in your templates.

``` .language-yaml
todo:
  - 'Make sausages out of leftover tuna casserole'
  - 'Change name to Simon. Refer to self in 3rd person.'
  - 'Build a sick blanket fort'
```

```
<h3>To-Do List</h3>
<ul>
    {{ todo }}
        <li>{{ value }}</li>
    {{ /todo }}
</ul>
```

``` .language-output
<h3>To-Do List</h3>
<ul>
    <li>Make sausages out of leftover tuna casserole</li>
    <li>Change name to Simon. Refer to self in 3rd person.</li>
    <li>Build a sick blanket fort</li>
</ul>
```
