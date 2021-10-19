---
id: 264048cb-30fd-4529-aa48-7236434d1ec4
title: 'List of Reserved Words'
template: page
categories:
  - development
  - troubleshooting
---
## As Field Names

This is the list of reserved words you shouldn't use as field names, in addition to the names of Statamic's [Tags](/tags) and [contextual variables](/variables).

- `content_type`
- `elseif`
- `endif`
- `endunless`
- `if`
- `reference`
- `resource`
- `unless`
- `value`

:::warning
Some of these _may_ work as field names in some circumstances, but can have unintended consequences, like overriding global data, behaviors, or creating issues with Vue components inside the Control Panel.
:::

### Special Cases

- `content` as a field name when _also_ utilizing the "content area" of your YAML front-loaded Markdown files (usually when working in the files directly)
- `global` with any datatype storing data as an array when there is _also_ a global field of the same name.
- `type` inside a Replicator set. The type is the handle of the set.

## As Form Fields

- `message`
- `messages`

## As Taxonomy Group Names
- `register`

## As Wildcard Variables in Statamic Routes

- `entry`
- `taxonomy`
