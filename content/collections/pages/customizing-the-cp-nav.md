---
id: 2ce74b48-d3cc-4b8a-a8d4-f514c0b1d6ff
blueprint: page
title: Customizing the Control Panel Navigation
intro: The Control Panel (CP) navigation is quite customizable. You can add your own sections, pages, and subpages, as well as hide or modify existing ones.
template: page
---

:::tip
This page refers to the Control Panel's side-bar navigation. Not to be confused with ["Navs"](/navigation), where you can create trees to be used for the front-end of your site.
:::

## Accessing CP Nav Preferences

Users can access CP Nav preferences through the sidebar under `Settings > Preferences`.

<figure>
    <img src="/img/cp-nav-preferences.webp" alt="CP Nav Preferences" class="u-hide-in-dark-mode">
    <img src="/img/cp-nav-preferences-dark.webp" alt="CP Nav Preferences" class="u-hide-in-light-mode">
    <figcaption>Manage your own CP nav!</figcaption>
</figure>

## Customizing CP Nav Preferences For Other Users

In order to customize CP nav preferences for other users, you must first enable [Statamic Pro](/tips/how-to-enable-statamic-pro), and you must either be a super user or have permissions to manage preferences.

<figure>
    <img src="/img/manage-preferences-permission.webp" alt="Manage Preferences Permission" class="u-hide-in-dark-mode">
    <img src="/img/manage-preferences-permission-dark.webp" alt="Manage Preferences Permission" class="u-hide-in-light-mode">
    <figcaption>Are you rad enough to manage global preferences?</figcaption>
</figure>

This will allow you to customize the default CP nav for all users, or on a role-by-role basis, though end-users will still have the ability to further customize their own CP nav as they see fit.

<figure>
    <img src="/img/preferences-other-users.webp" alt="CP Nav Preferences for Other Users" class="u-hide-in-dark-mode">
    <img src="/img/preferences-other-users-dark.webp" alt="CP Nav Preferences for Other Users" class="u-hide-in-light-mode">
    <figcaption>Manage the default CP nav for other users!</figcaption>
</figure>

## Extending Via Addon

On top of allowing the end user to customize their CP nav, Statamic also provides PHP helpers for [extending the CP navigation](/extending/cp-navigation) within an addon.
