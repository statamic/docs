---
title: Dirty State Tracking
id: bbf752d3-ffdb-4ac9-a5c5-0b32e3db9d6f
intro: |
  Prevent users from accidentally leaving the page and losing their work.
---
Accidentally navigating away from a page while you're in the middle of filling out a form could cause you to lose your progress and be really frustrating.
Statamic will pop up a warning if you're in the middle of something and about to leave, to give you a chance to change your mind. You can tap into this feature, too.

The component can track the dirty state from multiple places, and will only be considered clean once all of them are clean.

``` js
this.$dirty.add(name); // Mark a thing as dirty
this.$dirty.remove(name); // Clean it up
```

> If you're using a [publish container](/extending/publish-forms#container) (you should, if you're making a form), the dirty state 
> will be automatically tracked. Be sure to call `save()` on it when you save and it will mark it as clean.