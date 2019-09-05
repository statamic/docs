---
title: Env
overview: Output environment variable values.
parameters:
  -
    name: default|fallback
    type: string
    description: "In the event that the requested variable doesn't exist, this will be used a fallback."
id: 967d4bad-34a0-4a6a-8af1-6e88c6b900ed
---
## Example

This tag is a nice simple way to output values from your environment variables.

In your environment file (`.env`):

```
FOO=bar
```

```
1. {{ env:FOO }}
2. {{ env:HELLO }}
3. {{ env:HELLO default="world" }}
```

``` .language-output
1. bar
2.
3. world
```
