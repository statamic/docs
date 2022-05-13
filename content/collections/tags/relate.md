---
title: Relate
description: Converts fields to terms.
intro: The relate tag is used for converting fields to terms.
stage: 
id: 
---
## Overview
This tag is used for when you want to convert fields to terms for use in your front-end. A use-case would be [using terms without taxonomizing](/fieldtypes/terms#without-taxonomizing).

``` yaml
correlated_things:
  - classification/eggcellent
  - badge/honey
```

``` antlers
{{ relate:correlated_things }}
  <li><a href="{{ url }}">{{ title }}</a></li>
{{ /relate:correlated_things }}
```

``` html
<ul>
  <li><a href="/classification/eggcellent">Eggcellent</a></li>
  <li><a href="/badge/honey">Honey</a></li>
</ul>
```

:::tip
You can also use [augmentation](/fields#augmentation) to achieve something similar.
:::
