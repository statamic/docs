---
title: Suggest
image: /assets/fieldtypes/suggest.jpg
overview: Simple Select or Multi select fieldtype powered by autocomplete suggestions from flexible sources.
id: ec50b1fd-0c62-44e4-8314-1720ff60796d
options:
  -
    name: mode
    type: string *options*
    description: >
      The method of retrieving the suggestions. Only required when using a third party suggest mode.
  -
    name: options
    type: array *if not defined by third party mode*
    description: >
      The array of options for the user to select from
  -
    name: max_items
    type: integer
    description: >
      The maximum number of options to be selected. Leaving this blank will allow infinite values.
      Selecting `1` will save the value as a string instead of an array, and will display a dropdown
      instead of the tag UI.
  -
    name: create
    type: boolean *false*
    description: >
      If enabled, values may be manually entered. Otherwise, only suggested values may be selected.
---
The Suggest fieldtype allows you to select from a number of suggested values. Treat it like a regular dropdown, or
start typing to narrow down the suggestions.

The values come from either a predefined array of `options`, or from a third-party suggest mode.

## Suggest Modes

The suggestions in this field will normally come from the `options` array, which is a predefined list of values.

It is possible for an addon to provide suggestions to power this field. For example, an addon might create a suggest mode
that fetches tweets from a Twitter user's account. [Learn how to make a Suggest Mode](/knowledge-base/suggest-modes).
