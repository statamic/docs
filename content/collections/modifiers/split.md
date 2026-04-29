---
id: f1f9e882-e9e1-4161-8d6e-13fa9838dde1
blueprint: modifiers
modifier_types:
  - array
  - markup
  - utility
title: Split
---
Break an array or collection into a given number of (roughly equal) groups.

:::tip
Need a fixed number of items _per group_ instead of a fixed group count? The [chunk](/modifiers/chunk) modifier does the opposite — give it a _size_ and it makes as many groups as needed.
:::

For example, `split:3` on a 6-item array produces 3 groups of 2. Each group is available as `{{ items }}` in Antlers (or `$group['items']` in Blade).

::tabs

::tab antlers
```antlers
{{ collection:news as="posts" limit="6" }}
  {{ posts split="3" }}
  <div class="flex space-x-4">
    {{ items }}
      <a href="{{ url }}" class="bg-purple-800 text-white p-4">
        {{ title }}
      </a>
    {{ /items }}
  </div>
  {{ /posts }}
{{ /collection:news }}
```
::tab blade
```blade
<s:collection:news as="posts" limit="6">

  @foreach (Statamic::modify($posts)->split(3) as $group)
    <div class="flex space-x-4">
      @foreach ($group['items'] as $entry)
        <a href="{{ $entry->url }}" class="bg-purple-800 text-white p-4">
          {{ $entry->title }}
        </a>
      @endforeach
    </div>
  @endforeach

</s:collection:news>
```
::

```html
<div class="flex space-x-4">
  <a href="/ideas/book" class="bg-purple-800 text-white p-4">
    Book: Somehow I Manage
  </a>
  <a href="/ideas/party" class="bg-purple-800 text-white p-4">
    Party: Goodbye Toby
  </a>
</div>
<div class="flex space-x-4">
  <a href="/ideas/screenplay" class="bg-purple-800 text-white p-4">
    Screenplay: Threat Level Midnight
  </a>
  <a href="/ideas/art" class="bg-purple-800 text-white p-4">
    Art: A Stapler
  </a>
</div>
<div class="flex space-x-4">
  <a href="/ideas/poster" class="bg-purple-800 text-white p-4">
    Poster: Kids Playing Instruments
  </a>
  <a href="/ideas/mug" class="bg-purple-800 text-white p-4">
    Mug: World's Best Boss
  </a>
</div>
```
