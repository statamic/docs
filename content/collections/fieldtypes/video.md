---
title: Video
description: Extract embed URLs from Youtube, Vimeo, and HTML5 compatible video links and preview them right inline.
intro: |
  Extract embed URLs from Youtube, Vimeo, and HTML5 compatible video links and preview them right inline. Feel free watch the whole thing instead of working – we won't tell.
screenshot: fieldtypes/screenshots/v6/video.webp
screenshot_dark: fieldtypes/screenshots/v6/video-dark.webp
id: ced8b901-95bd-4006-b70e-4ea04d72fcb7
---
## Usage

Enter a video URL and it will be loaded in an embedded player directly beneath the field so you can preview it.

You may enter:

- YouTube URLs: `https://www.youtube.com/watch?v=s9F5fhJQo34`
- Vimeo URLs: `https://vimeo.com/22439234`
- mp4, ogv, mov, or webm URLs: `http://example.com/video.mp4`

## Data Structure

The Video field will save the URL of the video you've entered. If you paste embed code into the field, it will extract the proper URL for you.

``` yaml
video: https://www.youtube.com/watch?v=s9F5fhJQo34
```

## Templating

You can use the [is_embeddable](/modifiers/is_embeddable) and
[embed_url](/modifiers/embed_url) modifiers to display your video player.

::tabs

::tab antlers
```antlers
{{ if video | is_embeddable }}
    <!-- Youtube and Vimeo -->
    <iframe src="{{ video | embed_url }}" ...></iframe>
{{ else }}
    <!-- Other HTML5 video types -->
    <video src="{{ video | embed_url }}" ...></video>
{{ /if }}
```
::tab blade
```blade
@if (Statamic::modify($video)->isEmbeddable()->fetch())
	<!-- Youtube and Vimeo -->
	<iframe src="{{ Statamic::modify($video)->embedUrl() }}" ...></iframe>
@else
	<!-- Other HTML5 video types -->
	<video src="{{ Statamic::modify($video)->embedUrl() }}" ...></video>
@endif
```
::

### Provider, ID, and embed URL

The video field is augmented into an object that still outputs the URL you entered, but also gives you access to the video's provider, ID, and embed URL.

::tabs

::tab antlers
```antlers
{{ video }}             {{# https://www.youtube.com/watch?v=s9F5fhJQo34 #}}
{{ video:provider }}    {{# youtube #}}
{{ video:id }}          {{# s9F5fhJQo34 #}}
{{ video:embed_url }}   {{# https://www.youtube-nocookie.com/embed/s9F5fhJQo34 #}}
```
::tab blade
```blade
{{ $video }}               {{-- https://www.youtube.com/watch?v=s9F5fhJQo34 --}}
{{ $video->provider() }}   {{-- youtube --}}
{{ $video->id() }}         {{-- s9F5fhJQo34 --}}
{{ $video->embedUrl() }}   {{-- https://www.youtube-nocookie.com/embed/s9F5fhJQo34 --}}
```
::

| Variable | Description |
|----------|-------------|
| `url` | The URL that was entered. |
| `provider` | `youtube`, `vimeo`, `file` (a direct link to a video file), or `unsupported`. |
| `id` | The YouTube or Vimeo video ID. `null` for other providers. |
| `privacy_hash` | The privacy hash of an unlisted Vimeo video (e.g. the `abc123` in `vimeo.com/22439234/abc123`). `null` otherwise. |
| `embed_url` | The embeddable player URL for YouTube and Vimeo, the URL itself for video files, or `null` for anything unsupported. |

This lets you check the provider directly rather than reaching for modifiers:

```antlers
{{ if video:provider == 'file' }}
    <video src="{{ video }}" ...></video>
{{ elseif video:embed_url }}
    <iframe src="{{ video:embed_url }}" ...></iframe>
{{ /if }}
```

:::tip
These values are only available in templates. The REST API and GraphQL still return the plain URL string.
:::
