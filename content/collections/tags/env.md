---
title: Env
description: Fetches environment variables from your `.env` file
intro: The Env tag fetches environment variables from your `.env` file and can set default fallbacks.
parameters:
  -
    name: default
    type: string
    description: "In the event that the requested variable doesn't exist, this will be used a fallback. Default: `null`"
stage: 4
id: 967d4bad-34a0-4a6a-8af1-6e88c6b900ed
---
## Overview

[Environment variables](/configuration#environment-variables) are used to keep different settings based on the environment where your site is running. For example, you set `APP_DEBUG=true` on a local or staging site, but `APP_DEBUG=false` in your production (live) site.

## Example

In your environment file (`.env`), set a variable, and fetch it's value like so:

``` env
RAD_LEVEL=99
```

```
{{ env:RAD_LEVEL }}
{{ env:UNSET_VAR default="23" }}
```

``` output
99
23
```
