---
title: YAML
description: A YAML editor that _directly_ manages YAML.
overview: >
  A [code fieldtype](/fieldtypes/yaml) in YAML mode that _directly_ edits and stores YAML instead of an escaped string representation of said YAML.
screenshot: fieldtypes/screenshot/yaml.png
stage: 4
id: 25155800-8fd7-46c7-aad0-5daaf07543da
---
## Overview

This field is a [code fieldtype](/fieldtypes/code) that gets saved as YAML instead of a string. Your input is validated on save to make sure you don't write _invalid_ YAML.

:::tip
The YAML field is one of the "catch-all" solutions for when there's no better way to work with an odd data structure. **Recommended for developers only.**
:::

## Data Storage

You really should [know YAML](/yaml) if you're using this field, in which case you'll understand how the data is stored – exactly as written.

## Templating

Refer to the [YAML guide](/yaml) on how to work with data in general. We really can't be any more specific here. You understand, right?
