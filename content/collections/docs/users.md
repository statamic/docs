---
title: Users
intro: Users are the member accounts to your site or application. What a user can do with their account is up to you. They could have limited or full access to the Control Panel, a login-only area of the front-end, or even something more custom by tapping into Laravel.
template: page
id: 6b691e04-8f28-4eb2-8288-b61433883fe4
blueprint: page
pro: true
video: https://youtu.be/KuiPocGq3L8
---
## Overview

The most common and obvious reason users exist are to have the means to access the Control Panel and manage the content of your site. But there is so much more a user can do, if you so desire.

<figure>
    <img src="/img/users-index.png" alt="List of Statamic Control Panel users">
    <figcaption>Why hasn't the Hoff logged in?</figcaption>
</figure>

## Creating Users

The easiest way to create your **first user** is by running `php please make:user` terminal command. After entering basic information, setting a password, and saying `yes` to [super user](#super-admins), you can log into the control panel at `example.com/cp`.

<figure>
    <img src="/img/make-user.png" alt="Make User command" class="shadow-lg-teal rounded">
    <figcaption>This is all it takes to make your first user.</figcaption>
</figure>

You can also [create users by hand](/knowledge-base/creating-users-by-hand) in a YAML file if you'd prefer, or don't have access to the command line. And don't worry, the password field will automatically get encrypted as soon as Statamic spots it.

### New User Invitations

When creating users in the Control Panel you can send email invitations to help guide those users into activating their accounts and signing in for the first time. You can even customize a lovely little welcome message for them.

<figure>
    <img src="/img/user-invitation.png" alt="A user invitation screen">
    <figcaption>An opportunity for a knock knock joke, perhaps?</figcaption>
</figure>

:::tip
Be sure to [configure the email driver](/email) so those emails actually go out.
:::

## User Fields

You're more than welcome — encouraged even — to customize what fields and information you'd like to store on your users. For example, you could store author bios and social media links to be used in articles on your front-end.

To customize these fields, edit the included `user` [blueprint](/blueprints)  and configure it however you'd like. Just be sure to keep the required system fields:

| Field | Type | Required |
|-------|------|----------|
| `email` | `text` | Always |
| `groups` | `user_groups` | When using groups |
| `roles` | `user_roles` | When using roles |

## Permissions

<div class="mb-8">
    <a class="bg-black hover:bg-purple no-underline text-sm px-4 py-1 inline-block transform -rotate-3 text-mint font-display" href="/licensing">Pro Feature</a>
</div>

A User by itself has no permission to access or change any aspect of Statamic. It takes explicit permissions for a user to access the control panel, create, edit, or publish content, create users, and so on.

Permissions are grouped into **roles**, and are very simple to manage in the Control Panel and are stored in `resources/users/roles.yaml`.

In turn, **roles** are attached directly to individual users or [user groups](#user-groups).

### Statamic's native permissions: {#native-permissions}

| Permission | Handle |
|------------|--------|
| Access the Control Panel | `access cp` |
| Create, edit, and delete collections | `configure collections` |
| View entries | `view {collection} entries` |
| ↳  Edit entries | `edit {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Create entries | `create {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Delete entries | `delete {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Publish entries | `publish {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Reorder entries | `reorder {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Edit other author's entries | `edit other authors {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Publish other author's entries | `publish other authors {collection} entries` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Delete other author's entries | `delete other authors {collection} entries` |
| Create, edit, and delete structures | `configure structures` |
| ↳  View structure | `view {structure} structure` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Edit structure | `edit {structure} structure` |
| Edit global variables | `edit {global} globals` |
| View asset container | `view {container} assets` |
| ↳  Upload assets | `upload {container} assets` |
| ↳  Edit assets | `edit {container} assets` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Move assets | `move {container} assets` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Rename assets | `rename {container} assets` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Delete assets | `delete {container} assets` |
| View available updates | `view updates` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳  Perform updates | `perform updates` |
| View users | `view users` |
| ↳ Edit users | `edit users` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ Create users | `create users` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ Delete users | `delete users` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ Change passwords | `change passwords` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ Edit user groups | `edit user groups` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ Edit roles | `edit roles` |
| Configure forms | `configure forms` |
| View form submissions | `view {form} submissions` |
| &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;↳ Delete form submissions | `delete {form} submissions` |

### Super Users

Super Admin accounts are special accounts with **access and permission to everything**. This includes things reserved only for super users like the ability to _create more super users_. It's important to prevent the robot apocalypse and this is an important firewall. We're just doing our part to save the world.

## User Groups

<div class="mb-8">
    <a class="bg-black hover:bg-purple no-underline text-sm px-4 py-1 inline-block transform -rotate-3 text-mint font-display" href="/licensing">Pro Feature</a>
</div>

User groups allow you to attach roles, include users, thereby assign all the corresponding permissions automatically. This approach is much simpler than assigning roles individually if you have a lot users.

User groups are stored in `resources/users/groups.yaml`.

## Password Resets

Let's face it. People forget their passwords. A lot, and often. Statamic supports password resets. For users with Control Panel access, the login screen (found by default at `example.com/cp`) already handles this for you automatically.

You can also create your own password reset pages for front-end users by using the [user:forgot_password_form](/tags/user-forgot_password_form) tag.

The user will receive an email with a temporary, single-use token allowing them to set a new password and log in again.

## Password Validation

By default, passwords need to be 8 characters long. If you'd like to customize the default rules, you can use the `Password` rule object. (Requires at least Laravel 8.43).

These rules will be used when creating passwords throughout Statamic. In the `make:user` command, in the `user:register_form` tag, or during the password activation/reset flows. If you create the password by hand in user yaml files, the rules will be bypassed.

You can drop this into your `AppServiceProvider`'s `boot` method.

```php
use Illuminate\Validation\Rules\Password;

public function boot()
{
    Password::defaults(function () {
        return Password::min(16);
    });
}
```

Consult the [Laravel documentation](https://laravel.com/docs/8.x/validation#validating-passwords) to see all the available methods for customizing the password rule.

## Storing User Records {#storage}

While users are stored in files by default — like everything else in Statamic — they can also be located in a database or really anywhere else. Here are links to articles for the different scenarios you may find yourself in.

- [Storing Laravel Users in Files](/knowledge-base/storing-laravel-users-in-files)
- [Storing Users in a Database](/knowledge-base/storing-users-in-a-database)
- [Custom User Storage](/knowledge-base/storing-users-somewhere-custom)
- [Using an Independent Auth Guard](/knowledge-base/using-an-independent-authentication-guard)

## OAuth

In addition to conventional user authentication, Statamic also provides a simple, convenient way to authenticate with OAuth providers through [Laravel Socialite](https://github.com/laravel/socialite). Socialite currently supports authentication with Facebook, Twitter, LinkedIn, Google, GitHub, GitLab and Bitbucket, while dozens of additional providers are available though [third-party Socialite Providers](https://socialiteproviders.netlify.com/).

Learn how to [configure OAuth](/oauth) on your site.
