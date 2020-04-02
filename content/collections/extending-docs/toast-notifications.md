---
title: Toast Notifications
intro: Simple notification messages that "pop" into the screen like toast popping out of a toaster.
stage: 1
id: 52af4663-ebbd-467c-8659-9c7bb94cb7cc
---
You may display simple toast notifications through the `$toast` instance method.

``` js
this.$toast.info('message');    // Basic message
this.$toast.success('message'); // Green success
this.$toast.error('message');   // Red error
this.$toast.success('message', { dismissible: false }); // Hides the close button
this.$toast.success('message', { duration: 3000 }); // Auto-disappear after this many milliseconds
```
