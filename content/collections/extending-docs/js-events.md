---
id: b7519137-73b6-46c7-8432-da7725b1d9b4
title: Event Bus
---
For situations where emitting an event to the parent component doesn't make sense, Statamic has a global event bus. You can emit and listen to events directly on this which will be available to all Vue components.

``` js
// Emit from some component...
this.$events.$emit('event.name');

// Listen for it in another component...
this.$events.$on('event.name');
```

> The event bus is intended to be used for Vue component communication. If you want to listen
> for Statamic driven "events", you may want to check out [Hooks](/extending/hooks).