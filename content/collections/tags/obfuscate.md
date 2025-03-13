---
title: Obfuscate
description: Obfuscates content to foil screen-scraping nightmare bots from hell
intro: Whenever you need to obfuscate something, reach for the obfuscate tag. It's an obfuscating good time.
stage: 4
id: 161f6255-465d-41bd-8028-d6aba01cebbf

---
## Overview

This tag obfuscates content.

Obfuscation is a method of encoding content so that the **source code** is hard or impossible to understand. This is most often used on email addresses to prevent spambots from scraping them and signing the poor souls up for an endless chain of pharmaceutical drug emails.

::tabs

::tab antlers
```antlers
{{ obfuscate }}
  djjazzyjeff@angelfire.com
{{ /obfuscate }}
```
::tab
```blade
<s:obfuscate>
  djjazzyjeff@angelfire.com
</s:obfuscate>
```
::

```html
<!-- Users see this -->
djjazzyjeff@angelfire.com

<!-- Source code looks like this -->
&#x64;&#106;j&#x61;z&#x7a;&#121;je&#102;&#102;&#x40;&#97;&#110;&#103;&#x65;&#x6c;f&#x69;&#114;&#x65;&#x2e;&#x63;&#x6f;&#x6d;
```

## Related Delights

- [Obfuscate modifier](/modifiers/obfuscate)
- [How to pronounce obfuscate](https://www.youtube.com/watch?v=zaEg0gziFiU)
- [How to pronounce Schenectady](https://www.youtube.com/watch?v=e6IO_x3L53c)
