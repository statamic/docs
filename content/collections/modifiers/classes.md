---
id: ef8d4f96-e811-4343-a2cf-81e455ee8227
blueprint: modifiers
modifier_types:
  - string
  - array
title: Classes
---
This conditionally compiles a CSS class string using Laravel's `Arr::toCssClasses()` method.

The modifier expects an array of classes where the array key contains the class or classes you wish to add, while the value is a boolean expression. 

```yaml
is_active: false
has_error: true
```

```antlers
<div class="text-sm {{ ['p-4' => true, 'font-bold' => is_active, 'bg-red' => has_error] | classes }}">
  //
</div>
```

```html
<div class="text-sm p-4 bg-red">
  //
</div>
```
