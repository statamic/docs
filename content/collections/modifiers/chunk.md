---
id: 10b38f50-e33c-47e0-8e94-bc4dc551600f
blueprint: modifiers
modifier_types:
  - array
  - markup
  - utility
title: Chunk
---
Break arrays or collections into smaller (wait for it) chunks of any given size. This is useful for performing various gymnastics with your HTML markup.


```
{{ collection:news as="posts" limit="6" }}
  {{ posts chunk="3" }}
  <div class="flex space-x-4">
    {{ chunk }}
      <a href="{{ url }}" class="bg-purple-800 text-white p-4">
        {{ title }}
      </a>
    {{ /chunk }}
  </div>
  {{ /posts }}
{{ /collection:newsroom }}
```

```html
<div class="flex space-x-4">
  <a href="/ideas/book" class="bg-purple-800 text-white p-4">
    Book: Somehow I Manage
  </a>
  <a href="/ideas/party" class="bg-purple-800 text-white p-4">
    Party: Goodbye Toby
  </a>
  <a href="/ideas/screenplay" class="bg-purple-800 text-white p-4">
    Screenplay: Threat Level Midnight
  </a>
</div>
<div class="flex space-x-4">
  <a href="/ideas/art" class="bg-purple-800 text-white p-4">
    Art: A Stapler
  </a>
  <a href="/ideas/poster" class="bg-purple-800 text-white p-4">
    Poster: Kids Playing Instruments
  </a>
  <a href="/ideas/mug" class="bg-purple-800 text-white p-4">
    Mug: World's Best Boss
  </a>
</div>
```
