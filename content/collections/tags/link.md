---
title: Link
description: 'Generates URLs'
intro:  This tag will generate URLs, optionally using your fully qualified/absolute domain.
parameters:
  -
    name: src
    type: string
    description: |
      The relative URL you're generating the URL for.
  -
    name: absolute
    type: boolean
    description: |
      Make the URL absolute if it isn't already. Default: `false`.
stage: 2
id: ce8211b3-7e33-46ae-85ff-fe8880dafe11
---
## Overview
If you want to create a link to any URL in your site and want to be sure to include your site root and/or fully qualified domain name, this is the tag you're looking for.

**Assuming site root is `/`:**

```
{{ path src="fanny-packs" }}
{{ path src="fanny-packs" absolute="true" }}
```

``` output
/fanny-packs
https://example.com/fanny-packs
```

**Assuming site root is `/subdirectory/`:**

```
{{ path src="fanny-packs" }}
{{ path src="fanny-packs" absolute="true" }}
```

``` output
/subdirectory/fanny-packs
https://example.com/subdirectory/fanny-packs
```

**Assuming site root is `https://example.com/`:**

```
{{ path src="fanny-packs" }}
{{ path src="fanny-packs" absolute="true" }}
```

``` output
https://example.com/fanny-packs
https://example.com/fanny-packs
```
