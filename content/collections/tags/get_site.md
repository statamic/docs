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

```antlers
{{ get_site:english }}
    <a href="{{ permalink }}">
        Go to {{ name }}
    </a>
{{ /get_site:english }}
```

If you need to, you can pass the site handle dynamically:

```antlers
{{ get_site :handle="another_sites_handle" }}
    <!-- ... -->
{{ /get_site }}
```

You can also use it as a single tag:

```antlers
{{ get_site:english:permalink }}
```
