---
id: 47f8c4c4-8268-4375-adc4-b8c4521fbfd9
blueprint: page
title: Sidecar
intro: 'Edit external markdown content — LaraDocs, Jigsaw, and friends — as Statamic collections in the Control Panel, *in place*, without importing it or changing how the source system builds.'
template: page
related_entries:
  - 7202c698-942a-4dc0-b006-b982784efb03
  - 3c34ef5c-781e-4a22-a09b-25f58bdb58a8
  - 54548616-fd6d-44a3-a379-bdf71c492c63
  - 83145e6c-45d2-4e9c-a412-48a81f144224
---
:::warning
Sidecar is **experimental**. The core API, config shape, and driver contracts may change as we dogfood it. Pin package versions and expect sharp edges.
:::

## Overview

You've already got docs in LaraDocs. Or a Jigsaw site with a `source/docs/` folder and a `navigation.php`. The build pipeline works. The filesystem contract is sacred. You just want Statamic's Control Panel pointed at the real files — blueprints, structure trees, Live Preview, permissions — without a one-way import into `content/collections`.

That's Sidecar.

Sidecar is a **core framework** plus **driver packages**. Core teaches Statamic how to register collections that live outside the usual content directories. Drivers teach it the quirks of a specific SSG or docs tool.

```
Your markdown files  ←→  Sidecar driver  ←→  Statamic CP
       ↑
  still owned by LaraDocs / Jigsaw / whatever
```

## How it works

1. A driver package registers itself with `Sidecar::extend()` (and optionally `Sidecar::pair()` for install discovery).
2. You declare collections in `config/statamic/sidecar.php` — handle, driver, directory.
3. On boot, Sidecar configures each collection in memory via `Collection::register()`. No `content/collections/{handle}.yaml` required.
4. Entries resolve from the configured directory instead of `content/collections/{handle}`.
5. Drivers may sync the [structure](/structures) tree back to disk (nested folders) or to a nav file (`navigation.php`), and supply Visit / Live Preview URLs even when the collection has no Statamic route.

Cascade data you *do* save on disk (SEO Pro defaults, etc.) is still picked up when present — Sidecar starts from an existing on-disk collection when it finds one, then re-applies the driver config.

## Installation

Install Statamic 6, your SSG/docs package, and the matching Sidecar driver, then run the installer:

::tabs
::tab LaraDocs
```shell
composer require petebishwhip/laradocs statamic/sidecar-laradocs
php please sidecar:install laradocs
```
::tab Jigsaw
```shell
composer require tightenco/jigsaw statamic/sidecar-jigsaw
php please sidecar:install jigsaw
```
::

`php please sidecar:install` will:

- Detect paired Composer packages (or let you pick a driver)
- Require the driver package if needed
- Publish `config/statamic/sidecar.php`
- Optionally scaffold a default collection entry

Run it with no argument and it'll probe what's installed. Pass a driver handle when you already know what you want: `php please sidecar:install laradocs`.

## Configuration

Published config lives at `config/statamic/sidecar.php`:

```php
return [

    'collections' => [

        'docs' => [
            'driver' => 'laradocs',
            'directory' => base_path('docs'),
            // 'title' => 'Documentation',
            // 'blueprint' => 'custom_docs',
            // 'preview_url' => 'https://docs.example.com/{slug}',
        ],

    ],

];
```

| Key | Required | Purpose |
|---|---|---|
| `driver` | Yes | Registered driver handle (`laradocs`, `jigsaw`, …) |
| `directory` | Yes\* | Absolute or `base_path`-relative path to the markdown files |
| `title` | No | Collection title override |
| `blueprint` | No | Existing blueprint handle instead of the driver's fallback |
| `preview_url` | No | Preview target format (adds a Live Preview / Visit target) |
| `entry_class` | No | Custom entry class for filename / serialization quirks |

\*Drivers may supply a sensible default directory (e.g. LaraDocs reads `config('laradocs.path')`).

Driver packages can document additional keys — Jigsaw adds `navigation`, `url_prefix`, `site_url`, etc.

## Drivers

Concrete adapters ship as separate packages. Core doesn't know about LaraDocs or Jigsaw — it only knows the driver contract.

| Package | Content model |
|---|---|
| [`statamic/sidecar-laradocs`](https://github.com/statamic/sidecar-laradocs) | Nested folders + `_index.md` + per-level `order` front matter |
| [`statamic/sidecar-jigsaw`](https://github.com/statamic/sidecar-jigsaw) | Flat `source/docs/` + hierarchy in `navigation.php` |

### LaraDocs

- Tree mode is on. Drag to nest; files move on disk (`docs/guide/routing.md`).
- Section pages with children become `{slug}/_index.md`. The site root is `docs/_index.md`.
- Slugs stay plain filenames — nesting comes from folders, not slash-containing slugs.
- Reorder syncs sibling `order` front matter and prunes empty directories.
- Clears the LaraDocs cache after save / delete / tree sync.
- Visit URL uses the LaraDocs route prefix; Live Preview hits a Sidecar action route that renders from the WIP token.

### Jigsaw

Meant for the [Jigsaw docs template](https://github.com/tighten/jigsaw-docs-template) layout.

- Pages stay **flat** on disk (`source/docs/{slug}.md`).
- Hierarchy lives in `navigation.php` — the CP tree rewrites that file; first boot seeds the tree from it when no tree file exists yet.
- External / manual nav links that aren't collection entries are preserved.
- New pages get the `extends` + `section` front matter Jigsaw expects.
- Visit URL uses `site_url` + `url_prefix`; Live Preview uses a Sidecar action route (markdown body + nav; full Blade `extends` rendering is still WIP).

## What you get in the CP

Sidecar collections show up like any other collection:

- Edit entries with blueprints (driver fallback, or your own on-disk / configured blueprint)
- Structure / Tree view when the driver enables it
- Permissions, revisions (if you turn them on), and the rest of the usual CP tooling
- Live Preview and Visit URL via driver `previewUrl()` and/or `preview_url` / preview targets — **no collection route required**

Unknown front matter is preserved on save. The driver's blueprint doesn't have to list every key your SSG already uses.

### Deleting a Sidecar collection

Removing the collection config (or the in-memory registration) does **not** wipe the external content directory. Your docs stay put. That's the whole point.

## Nested folders vs nav files

Two nesting strategies, same CP tree UI:

**Nested folders** (`usesNestedFolders() === true`, e.g. LaraDocs)

On `CollectionTreeSaved`, Sidecar rewrites each entry's path from tree ancestry, syncs sibling order through the driver, and deletes directories left empty after moves. `page.md` ↔ `page/_index.md` when a page gains or loses children.

**Driver-owned nav** (e.g. Jigsaw)

Files stay flat. The driver listens for tree/entry changes and rewrites its own navigation source of truth.

Either way: **no slash-containing slugs**. Nesting is real folders or a nav file — not path-slugs.

## Live Preview

Sidecar collections typically have `routes` set to `null` — the SSG owns URLs. Preview still works because:

1. `Collection::hasLivePreview()` is true when preview targets exist (not only when a route exists).
2. Drivers set preview targets (often a Sidecar action route that renders from the Live Preview token).
3. `Entry::uri()` / `url()` fall back to the driver's `previewUrl()` when there's no Statamic route, so Visit URL works too.

You can also force a target from config:

```php
'docs' => [
    'driver' => 'jigsaw',
    'directory' => base_path('source/docs'),
    'preview_url' => 'http://localhost:8000/docs/{slug}',
],
```

See [Live Preview](/live-preview) for headless / custom-rendering details.

## Git automation

If you use [Git Automation](/git-automation), add your Sidecar content directories to the tracked `paths` so CP edits get committed:

```php
// config/statamic/git.php
'paths' => [
    base_path('content'),
    base_path('docs'), // LaraDocs
    // base_path('source/docs'),
    // base_path('navigation.php'),
    // ...
],
```

Absolute paths into other repos work — Statamic will stage/commit relative to that repo when it detects one.

## Multi-site

At this time, Sidecar does not support multi-site for the "external" content.

## Writing a driver

Drivers are the extension point. Register from a service provider:

```php
use Statamic\Facades\Sidecar;
use Acme\Docs\AcmeDocsDriver;

public function register()
{
    Sidecar::extend('acme', function ($app, array $config, string $handle) {
        return new AcmeDocsDriver($config, $handle);
    });

    // Optional: let `php please sidecar:install` detect the SSG package
    Sidecar::pair('acme/docs-ssg', 'acme/sidecar-acme');
}
```

Extend `Statamic\Sidecar\Drivers\Driver` (or implement `Statamic\Sidecar\Driver`) and override what you need:

| Method | Role |
|---|---|
| `title()` | Default collection title |
| `directory()` | Where the markdown lives |
| `defaultBlueprint()` / `blueprint()` | Fallback blueprint when none exist on disk |
| `configure(Collection)` | Structure, sort, preview targets, routes, etc. |
| `afterBoot` / `afterSave` / `afterDelete` | Cache clears, nav rewrites, seeding |
| `previewUrl(Entry)` | Visit URL (+ URI fallback) |
| `usesNestedFolders()` | Opt into core tree → folder sync |
| `indexFileName()` | Section index basename (default `_index`) |
| `syncOrder(Entry, int)` | Persist sibling position (e.g. `order` FM) |
| `afterTreeSynced` | Hook after nested-folder relocation |
| `entryClass()` | Custom entry class when filenames diverge from Statamic defaults |

Minimal skeleton:

```php
use Statamic\Sidecar\Drivers\Driver;
use Statamic\Fields\Blueprint;

class AcmeDocsDriver extends Driver
{
    public function title(): string
    {
        return 'Docs';
    }

    protected function defaultBlueprint(): Blueprint
    {
        return $this->makeBlueprint([
            'title' => 'Doc',
            'fields' => [
                ['handle' => 'content', 'field' => ['type' => 'markdown']],
            ],
        ]);
    }

    public function previewUrl($entry): ?string
    {
        return url('docs/'.$entry->slug());
    }
}
```

Ship it as a Composer package, `Sidecar::pair()` it to the SSG it wraps, and `php please sidecar:install` can discover it like the first-party drivers.

## API surface (core)

Useful bits if you're extending or debugging:

```php
use Statamic\Facades\Sidecar;
use Statamic\Facades\Collection;

Sidecar::extend('acme', $callback);
Sidecar::pair('acme/ssg', 'acme/sidecar-acme');
Sidecar::manages('docs');          // bool
Sidecar::driver('docs');           // Driver instance
Sidecar::handles();                // collection handles from config
Sidecar::registeredDrivers();      // driver handles from extend()

Collection::register($collection); // in-memory collection (no YAML required)
$collection->directory($path);     // custom entry directory
$collection->entryBlueprintFallback($blueprint);
$collection->hasLivePreview();     // routes *or* preview targets
```

## What Sidecar is not

- Not an importer. Files stay where they are.
- Not a replacement for normal Statamic collections. Use those when Statamic owns the content.
- Not a full SSG runtime inside Statamic. Preview rendering is driver-specific and may be thinner than a production build (especially Blade layouts).
