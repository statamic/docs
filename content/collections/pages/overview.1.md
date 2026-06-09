---
id: e0e93aba-4abc-4433-9257-3321a4521d60
blueprint: page
title: 'Control Panel Overview'
nav_title: Overview
intro: >
    The Statamic Control Panel is where you manage everything that makes your site… well, your site. It's the admin interface you use to create and edit content, manage users and permissions, tweak settings, access utilities, and interact with addons — all without needing to touch the filesystem directly
---
<figure>
    <img src="/img/screenshot-cp-v6.webp" alt="Statamic v6 Control Panel" class="u-hide-in-dark-mode">
    <img src="/img/screenshot-cp-v6-dark.webp" alt="Statamic v6 Control Panel" class="u-hide-in-light-mode">
    <figcaption>Behold — the Statamic Control Panel!</figcaption>
</figure>

The control panel is built to be fast, modern, and flexible — and it gets a lot smarter in v6 with things like a command palette and updated UI patterns designed for real editors and developers alike.

Below is a quick explanation of the major areas you'll see once you're logged in.

## Dashboard

The first screen you see after signing in is the [Dashboard](/dashboard) — a customizable area where you can add widgets for things you care about: recent entries, scheduled content, form submissions, updates, shortcuts, and more. Configure it once and it becomes your command center.

## Content Management

This is where the magic happens. [Collections](/collections) organize your content types — blog posts, pages, products, whatever you need. Each collection can have multiple [blueprints](/blueprints) defining different field structures, and you can use [globals](/globals) for site-wide content that appears everywhere.

The [Asset Browser](/assets) handles all your files — images, documents, videos — with built-in image editing, organization, and optimization tools.

## Users & Permissions

The Users section lets you create, manage, and invite people who can log into the control panel. [Roles and permissions](/users) let you control what each user or role can see and do, from read-only editors to full administrators.

## Command Palette

Hit `cmd+k` (or `ctrl+k` on Windows/Linux) and the Command Palette pops up — a quick way to navigate around the control panel, jump right into editing specific entries, and run actions without clicking through menus. It's like Spotlight for your CMS.

## Preferences

Every user can adjust their own Preferences — like theme (light/dark), start page, locale, and more, while admins can also set defaults or role-based preferences. Make the control panel work the way you work.

## Forms & Submissions

[Forms](/forms) let you collect data from your site visitors — contact forms, newsletter signups, surveys, whatever. All submissions are stored in the control panel where you can view, export, or process them however you need.

## Content Tools

The control panel includes powerful tools that make content work easier:

[Live Preview](/live-preview) — see your changes as you write, with real-time updates as you edit.

[Git Automation](/git-automation) — manage how content updates sync with your Git workflow, keeping your content and code in sync.

[Revisions](/revisions) — create versions of your content, track changes, and easily rollback to previous versions of your entries.

[Utilities](/utilities) — standalone tools with their own screens and permissions, like the Cache Manager, PHP Info Viewer, and Email Config.

[Multi-Site](/multi-site), [Translations](/cp-translations), [Conditional Fields](/control-panel/conditional-fields), [Elevated Sessions](/control-panel/elevated-sessions), [White Labeling](/control-panel/white-labeling), and more — all features that let you shape the CP experience to your needs.

## Navigation & Extensibility

Statamic's control panel nav is not set in stone. You can [customize what editors see](/control-panel/customizing-the-cp-nav), hide sections they don't need, reorder items, and if you're building addons you can extend or add your own control panel navigation items. The control panel adapts to your workflow, not the other way around.
