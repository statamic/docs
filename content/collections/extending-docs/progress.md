---
title: Progress
id: 28068f9a-f269-4646-87e4-881e5477558d
intro: |
  Control the magic progress bar at the top of the page.
---
You can control the progress bar at the top of the page through the `$progress` instance method.
This progress bar will get a little further in small intervals automatically but will never reach 100% until
it's told to.

The component can track the progress from multiple places, and will only be considered complete once all of them are complete.

``` js
this.$progress.start($name); // Starts the progress bar
this.$progress.complete($name); // Instantly progress to 100% and disappear

this.$progress.loading($name, true); // Alias of .start() - Useful for passing a boolean
this.$progress.loading($name, false); // Alias of complete()

this.$progress.names(); // The names of the items that are being tracked.
this.$progress.count(); // How many are being tracked.
this.$progress.isComplete(); // Whether all the items that were being tracked have completed.
```

> If you have a component that may appear multiple times on one page (for example, a fieldtype), 
> make sure the name is unique. All Vue components already have a unique `_uid` property that could be used for this.
>
> ``` js
> this.$progress.start('things' + this._uid);
> ```
