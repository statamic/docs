---
title: Link
description: 'Generates URLs'
intro:  Generate fully qualified URLs with the option to include your domain.
parameters:
  -
    name: to|src
    type: string
    description: |
      Generate a URL to this relative path string.
  -
    name: absolute
    type: boolean
    description: |
      Make the URL absolute if it isn't already. Default: `false`.
  -
    name: id
    type: string
    description: |
      ID of the entry to link to.
  -
    name: in
    type: string
    description: |
      Handle of the site you want to link to (only when using Multi-Site).
stage: 4
id: ce8211b3-7e33-46ae-85ff-fe8880dafe11
---
## Overview
You can create a fully qualified URL to any resource, asset, or page on your site using a path relative string.

For example, if you had a link to `<a href="fanny-packs">`, it would be broken if you left that relative area of the site. By using the link tag you can ensure it's relative to your site root, and include the domain if needed.

::tabs

::tab antlers
```antlers
{{ link to="fanny-packs" }}
{{ link to="fanny-packs" absolute="true" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:link to="fanny-packs" />
<s:link to="fanny-packs" absolute="true" />>

{{-- Using Fluent Tags --}}
{{ Statamic::tag('link')->to('fanny-packs') }}
{{ Statamic::tag('link')->to('fanny-packs')->absolute(true) }}
```
::

```html
/fanny-packs
https://example.com/fanny-packs
```

## Link to Entries

You can also link to entries using their ID directly:

::tabs

::tab antlers
```antlers
{{ link id="1715c9a8-0662-4ca7-b9ea-1ad642431fae" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:link id="1715c9a8-0662-4ca7-b9ea-1ad642431fae" />

{{-- Using Fluent Tags --}}
{{ Statamic::tag('link')->id('1715c9a8-0662-4ca7-b9ea-1ad642431fae') }}
```
::

``` output
/the-pages-slug
```

When using Multi-Site, the URL automatically links to the entry on the current site. If you want to link to a specific site instead, you can add the `in` parameter:

::tabs

::tab antlers
```antlers
{{ link id="1715c9a8-0662-4ca7-b9ea-1ad642431fae" in="spanish" }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:link id="1715c9a8-0662-4ca7-b9ea-1ad642431fae" in="spanish" />

{{-- Using Fluent Tags --}}
{{ Statamic::tag('link')->id('1715c9a8-0662-4ca7-b9ea-1ad642431fae')->in('spanish') }}
```
```
::

``` output
/es/el-asdf-de-la-pagina
```
