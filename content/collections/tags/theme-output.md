---
title: Output
overview: Render the output of any file in your theme.
parameters:
  -
    name: src
    type: string
    description: >
      The path to the file, relative to the
      theme directory.
id: 3cb29c4f-96d2-4c6f-8e83-51facf2ae8ab
---
## Example {#example}
```
{{ theme:output src="svg/logo.svg" }}
```
``` .language-output
<svg>...</svg>
```
