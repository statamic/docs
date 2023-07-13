---
id: 50ed54f8-18b3-4b46-b0d7-6fedc07ad81f
blueprint: fieldtype
title: Icon
description: 'Simple UI to select SVG icons from a dropdown.'
intro: 'Give your users a list of icons to choose from. This field supports search and keyboard commands, and can be configured to use your own icons or ones managed by Statamic.'
screenshot: fieldtypes/screenshots/icon.png
options:
  -
    id: nKVDUK7I
    name: directory
    type: string
    description: 'Optionally set the path to the directory (in your resources folder) containing desired icons. Default: uses system icons.'
    required: false
  -
    id: 752XSotc
    name: folder
    type: string
    description: 'Optionally set a subdirectory contain a specific set of icons.'
    required: false
  -
    id: u8yCCuXb
    name: default
    type: string
    description: 'Set the default option key. Default: none.'
    required: false
---
## Overview

The Icon field allows you to easily select icons from the Control Panel's default list, or define the path to the directory and/or folder of your own that contains SVG icons.

It has a very minimal UI which will help streamline your Blueprints and help authors build pages faster with less clicks.


## Templating

Icon fields return inline string of the selected SVG icon.

```
{{ icon }}
```

```html
<svg viewBox="0 0 24 24"><path fill="currentColor" d="M11.983 0a12.206 12.206 0 0 0-8.51 3.653A11.8 11.8 0 0 0 0 12.207C-.008 18.712 5.26 23.992 11.765 24h.249c6.678-.069 12.04-5.531 11.986-12.209C24.015 5.293 18.76.013 12.262-.003L11.983 0zM10.5 16.542a1.475 1.475 0 0 1 1.421-1.529l.028-.001h.027c.82.002 1.492.651 1.523 1.47a1.475 1.475 0 0 1-1.419 1.529l-.03.001h-.027a1.53 1.53 0 0 1-1.523-1.47zM11 12.5v-6a1 1 0 0 1 2 0v6a1 1 0 0 1-2 0z"></path></svg>
```
