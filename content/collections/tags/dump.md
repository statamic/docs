---
title: Dump
description: Dump the variables in the current view context
intro: The dump tag is used for debugging data inside your current view context.
stage: 5
id: 32bc9a50-3b12-11e6-bdf4-0800200c9a66
---
## Overview
This tag is useful for debugging. It will stop execution of the page and render the raw data of the variables in your current context (page, variable loop, etc).

Dropping it a template or layout will show you all the data the data that's been injected into the view layer.

```
{{ dump }}
```

Dropping it inside a loop will jump all the data _just for that loop context_.

```
{{ gallery }}
  {{ dump }}
{{ /gallery }}
```

> You can also use the [dump modifier](/modifiers/dump) to a similar effect.
