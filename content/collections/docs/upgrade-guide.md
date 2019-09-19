---
title: 'Upgrade Guide'
intro: A guide for upgrading your existing Statamic v2.x projects to v3.0.
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568743749
id: f12f8ba3-19ff-48cb-a07b-653b05082d7e
blueprint: page
---
## Overview
Statamic 3 takes everything you love about v2, rewrites all the old stuff (Laravel 5.1 and Vue.js 1) with the latest hotness, adds roughly 80 fantastic new features, and speeds up performance by 5x. What's not to love about that?

## Breaking Changes: Core

First, let's look at the breaking changes on the core application side. These would be changes that affect the control panel, front-end, cli, and generally anything that doesn't require custom PHP.

### Globals

- Data gets nested inside a `data` key. This separates the data from the meta data, which you don't really want to be used as global variables.
- When using multiple sites, the data gets stored in completely separate files.

### Theming

- One `resources/views` directory instead of separate `templates`, `layouts`, and `partials` directories.
- Removed `theme:partial` tag in favor of `partial`.
- The `content` field is no longer automatically parsed for antlers. You can flag it for parsing in the blueprint. (As well as any other fields)

### Fieldtypes

- Array fieldtype terminology was changed from `value => text` to `key => value`, and thus config options were also changed to `add_button`, `key_header` and `value_header` to match the new terminology.
- Relate and Suggest fieldtypes has been removed in favor of the Relationship fieldtype

### Fieldsets

Fieldsets technically still exist, although they are are a now a smaller, companion feature to Blueprints.
Blueprints get attached to content. Fieldsets are an optional feature and can be used inside blueprints.

- In content etc, you should reference `blueprint: foo`  instead of `fieldset: foo`.
- There is no more `fieldsets` fieldtype. You should use the `blueprints` fieldtype.
- Field conditions use a slightly different syntax for multiple `OR` conditions and null/empty checks.
- Consider using the `statamic:migrate:fieldset` command to convert your v2 fieldsets to blueprints.

### Tags

- Removed the `get_values` tag in favor of `get_content`.
- Removed the `entries` and `entries:listing` tags in favor of `collection`.
- Removed the `pages` tag in favor of `collection`.
- `get_content` now only accepts IDs, not URLs.
- `relate` no longer inherits paramaters from the `collection` tag.
- `form:submissions` no longer inherits paramaters from the `collection` tag.
- Removed `name` element in form tag `fields` array in favor of `handle`.
- Replaces `field` element in form tag `fields` array with renderable view.
- `$this->tag_method` is now `$this->method`.

### Conditions

Content tag conditions still exist, but now use our new content query builders under the hood.  It's worth noting that some of these conditions may differ in behavior slightly, as they are now implemented using more agnostic query builder compatible comparisons or regular expressions instead of PHP logic.  That said, the most notable breaking changes are as follows:

- All comparisons and regex patterns are now case-insensitive by default.
- `is`, `equals`, `not`, `isnt`, and `aint` no longer work with `_strict` modifier.
- `contains` and `doesnt_contain` no longer work on array/object data.
- `matches`, `match`, `regex` and `doesnt_match` now ignore pattern delimiters and modifiers.
- `is_uppercase`, `is_lowercase`, `is_today`, `is_yesterday`, `is_between`, `is_leap_year`, `is_weekday`, `is_weekend`, `in_array` and `is_json` conditions were removed.


## Breaking Changes: API

### Global Functions

- `cp_resource_url()` is now `Statamic\Statamic::assetUrl()` (being consistent with [what Laravel considers an asset](https://laravel.com/docs/5.8/mix))
- `resource_url()` is now `Statamic\Statamic::url()`
- Removed `site_root()`
- Removed `resources_root()`
- Removed `format_input_options()` from both PHP and JS (use HasInputOptions mixin)

### API\Entry

- Removed `countWhereCollection()`
- `whereCollection()` now only supports a single collection (use `whereInCollection()` if you need to pass multiple)


### API\URL

- Removed `removeSiteRoot()`

### Suggest Modes

Suggest modes have been replaced by [customized relationship fieldtypes](/guide/extending/relationship-fieldtypes.html).