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
this.$toast.success('message', { duration: 3000 }); // Auto-disappear after this many milliseconds
```

You may also trigger these from the server using the `Toast` facade.

```php
use Statamic\Facades\Toast;

Toast::info('message');
Toast::success('message');
Toast::error('message');

Toast::info('message')->duration(3000);
```

You don't have to return them to a response. Simply calling them is enough. They will automatically routed through the response into JavaScript.
