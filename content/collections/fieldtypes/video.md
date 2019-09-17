---
title: Video
description: Extract consistent URLs from Youtube, Vimeo, and HTML5 compatible video links and preview them right inline.
overview: |
  Extract consistent URLs from Youtube, Vimeo, and HTML5 compatible video links and preview them right inline.
image: /assets/fieldtypes/video.jpg
added_in: 2.8
id: ced8b901-95bd-4006-b70e-4ea04d72fcb7
---
## Usage

Enter a video URL and it will be loaded and displayed in an embedded player directly beneath the field so you can preview and confirm. Or watch the whole thing instead of working. We don't tell anyone.

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

Since the field saves regular Video URLs, you can use the [is_embeddable](/modifiers/is_embeddable) and
[embed_url](/modifiers/embed_url) modifiers to display your video player.

```
{{ if video | is_embeddable }}
    <!-- Youtube and Video -->
    <iframe src="{{ video | embed_url }}" ...></iframe>
{{ else }}
    <!-- Other HTML5 video types -->
    <video src="{{ video | embed_url }}" ...></video>
{{ /if }}
```
