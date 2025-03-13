---
types:
  - asset
id: 89e75dec-7f33-4217-b040-2c2a18de5d83
---
A boolean for whether the asset is an video.

::tabs

::tab antlers
```antlers
{{ if is_video }}
    <video controls>
        <source src="{{ url }}" type="video/mp4">
        Sorry, your browser doesn't support embedded videos.
    </video>
{{ else }}
    <a href="{{ url }}">Download</a>
{{ /if }}
```
::tab blade
```blade
@if ($is_video)
  <video controls>
    <source src="{{ $url }}" type="video/mp4">
    Sorry, your browser doesn't support embedded videos.
  </video>
@else
  <a href="{{ $url }}">Download</a>
@endif
```
::

