---
title: Video
description: Extract embed URLs from Youtube, Vimeo, and HTML5 compatible video links and preview them right inline.
intro: |
  Extract embed URLs from Youtube, Vimeo, and HTML5 compatible video links and preview them right inline. Feel free watch the whole thing instead of working – we won't tell.
screenshot: fieldtypes/screenshot/video.jpg
stage: 4
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

```
{{ if video | is_embeddable }}
    <!-- Youtube and Vimeo -->
    <iframe src="{{ video | embed_url }}" ...></iframe>
{{ else }}
    <!-- Other HTML5 video types -->
    <video src="{{ video | embed_url }}" ...></video>
{{ /if }}
```
