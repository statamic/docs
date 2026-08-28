---
name: document-release
description: Reviews the changelog from the latest release and updates the documentation.
---

Document the latest **minor** release of `statamic/cms` in this repo (`statamic/docs`). Work happens on a dedicated branch, one commit per documented feature, finishing with a PR the user reviews manually.

## 1. Find the release

```sh
gh release list --repo statamic/cms --limit 30
```

Statamic ships frequent patch releases (`v6.27.1`, `v6.27.2`, ...) between minors. Walk the list from newest to oldest and take the first tag matching `vX.Y.0` — that's the latest minor.

Check whether a branch or PR for that tag already exists before doing anything else:

```sh
git fetch origin
git branch --list <tag> && git ls-remote --heads origin <tag>
gh pr list --repo statamic/docs --head <tag>
```

If any of those exist, stop and ask the user whether to resume that work or start over — don't silently overwrite it.

## 2. Read the changelog

```sh
gh release view <tag> --repo statamic/cms
```

Notes are split into `## What's new` and `## What's fixed`. `What's new` is exclusively new functionality. `What's fixed` is everything else — bug fixes, but also improvements to existing features (new options, UI/behavior changes) mixed in with plain fixes.

Build a candidate list:
- Every `What's new` entry.
- Any `What's fixed` entry that reads as a behavior change to something already documented (e.g. "Add X option to Y", "Improve Z UI", "Allow ..."), not a pure bug fix.

Skip plain bug fixes, performance-only changes, translations, and internal refactors — nothing for a docs reader to act on.

## 3. Research each candidate

For each entry, look at the linked number:

```sh
gh pr view <number> --repo statamic/cms
gh pr diff <number> --repo statamic/cms
```

(Fall back to `gh issue view` if it's not a PR.) Read the actual diff, not just the title — the changelog line is often too terse to document from directly. For a fieldtype/field option, find the exact option name, type, and default in the PHP/Vue source. For a modifier/tag, find the exact parameter name.

Read the PR body itself too, not just the diff. Authors often already explain the feature, why it exists, and include a usage example or config snippet — sometimes it's close enough to adapt directly into the doc rather than writing the explanation from scratch. Still rewrite it to match the doc's existing voice and conventions (step 5), and verify any example against the actual diff before using it — PR descriptions can describe an earlier version of the change.

Drop anything that turns out to already be documented, or that's a private/internal API not meant for end users.

If nothing survives triage, tell the user there's nothing to document for this release and stop — don't create an empty branch or PR.

## 4. Set up the branch

Check `git status` first — if the working tree isn't clean, stop and ask rather than switching branches.

```sh
git checkout 6.x
git pull
git checkout -b <tag>
```

## 5. Document each feature

For every surviving candidate, find where it belongs before writing anything:

- **Fieldtype option** → `content/collections/fieldtypes/<name>.md` — add to the `options:` frontmatter array and, if it needs explaining beyond the one-liner, a section in the body.
- **Modifier** → `content/collections/modifiers/<name>.md`
- **Tag / tag parameter** → `content/collections/tags/<name>.md`
- **Variable** → `content/collections/variables/<name>.md`
- **Widget** → `content/collections/widgets/<name>.md`
- **REST/GraphQL API behavior** → `content/collections/resource_apis/*.md`
- **General feature/concept** → search `content/collections/pages` for the existing page it extends (e.g. multisite, live preview, permissions) and add a section there.

Use `Grep`/`Glob` to find the file — don't guess a filename.

Before writing, read that file (and one or two sibling files if useful) and copy its exact conventions: frontmatter shape, heading levels, `::tabs`/`::tab antlers`/`::tab blade` blocks, admonitions, how defaults are phrased ("Default: `x`."), code fence languages. Match the existing voice — don't introduce a new style. Don't invent screenshot paths; leave `screenshot`/`screenshot_dark` fields alone unless a matching asset already exists in this repo.

### If it's a genuinely new feature with no existing home

This is the rare case — check hard for an existing page to extend first.

1. Create the entry under `content/collections/pages/` following the frontmatter shape of a similar page (`id` as a fresh lowercase UUID, `blueprint: page`, `title`, `template` only if the page needs one).
2. Add it to the relevant tree in `content/trees/collections/pages.yaml` and the matching nav tree in `content/trees/navigation/*.yaml`, as a sibling of the closest related existing page (same `entry: <uuid>` structure).
3. Flag this placement explicitly in the PR description — nav placement is a judgment call and needs a human look.

## 6. Commit

One commit per changelog entry documented, even if it touches more than one file. Use backticks around class/method/option/field names, e.g.:

```
Document `compact` mode for the array fieldtype
```

Add a trailer line referencing the source:

```
Ref: statamic/cms#15219
```

Only stage the files for that feature — don't bundle unrelated changes into one commit.

## 7. Push and open the PR

```sh
git push -u origin <tag>
```

```sh
gh pr create --repo statamic/docs --base 6.x --title "Document <tag>" --body "..."
```

PR body: one bullet per documented feature, each linking back to the source PR, e.g.:

```md
This pull request documents the new features and improvements from [<tag>](https://github.com/statamic/cms/releases/tag/<tag>).

- Documented `compact` mode for the array fieldtype — statamic/cms#15219
- Documented the `safe` option on `to_json` — statamic/cms#15260
```

If anything from step 5's "genuinely new feature" branch happened, call out the nav placement for review under its own bullet or a short "Needs a look" section.

## 8. Report back

Tell the user the PR URL and, briefly, what got skipped and why (e.g. "skipped #15251, perf-only" ) so they know the triage was deliberate, not missed.
