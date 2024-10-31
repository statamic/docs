---
id: 6761887c-a062-488f-a43e-87b22326215f
blueprint: tag
title: 'Get Site'
intro: "It gets a site's config, given it's handle."
description: "Fetches a site's config, given it's handle."
stage: 4
---
## Overview

This tag lets you get a site's config. It's useful if you need to display information, like site names or URLs, outside of the context of that site.

For example, you might want to output a site's name & logo in your footer:

::tabs

::tab antlers
```antlers
{{ get_site:english }}
    <a href="{{ permalink }}">
        Go to {{ name }}
    </a>
{{ /get_site:english }}
```
::tab blade
```blade
<s:get_site:english>
  <a href="{{ $permalink }}">
    Go to {{ $name }}
  </a>
</s:get_site:english>
```

You can also alias the result, if you need to:

```blade
<s:get_site:english as="the_site">
  {{ $the_site->name }}
</s:get_site:english>
```
::

If you need to, you can pass the site handle dynamically:

::tabs

::tab antlers
```antlers
{{ get_site :handle="another_sites_handle" }}
    <!-- ... -->
{{ /get_site }}
```
::tab blade
```blade
<s:get_site :handle="$another_sites_handle">
  <!-- ... -->
</s:get_site>
```
::

You can also use it as a single tag:

::tabs

::tab antlers
```antlers
{{ get_site:english:permalink }}
```
::tab blade
```blade
{{-- Using Antlers Blade Components --}}
<s:get_site:english:permalink />

{{-- Using Fluent Tags --}}
{{ Statamic::tag('get_site:english:permalink') }}
```
::
