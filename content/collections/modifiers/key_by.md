---
id: 66b59b24-e908-a7df-fe01-f10e79487d22
blueprint: modifiers
title: 'Key By'
modifier_types:
  - array
---
Re-keys a numerically indexed array using the value of a given key on each item. Handy when you want to target specific items by name instead of looping, like the `fields` array inside a form tag.

```yaml
fields:
  -
    handle: name
    display: 'Your Name'
  -
    handle: email
    display: 'Email Address'
```

::tabs

::tab antlers
```antlers
{{ rekeyed = fields | key_by('handle') }}

<div class="name-field">{{ rekeyed:name:display }}</div>
<div class="email-field">{{ rekeyed:email:display }}</div>
```
::tab blade
```blade
@php $rekeyed = Statamic::modify($fields)->keyBy('handle')->fetch(); @endphp

<div class="name-field">{{ $rekeyed['name']['display'] }}</div>
<div class="email-field">{{ $rekeyed['email']['display'] }}</div>
```
::

```html
<div class="name-field">Your Name</div>
<div class="email-field">Email Address</div>
```

:::tip
If two items share the same key, the last one wins. Pick a key that's unique across the array (like `handle` or `id`).
:::
