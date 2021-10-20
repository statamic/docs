---
id: 55993382-c928-48d0-8559-c88b226d4657
title: 'Creating Users by Hand'
intro: 'Did you know you can create users by hand by making new text files? Well now you do. Here''s how.'
template: page
categories:
  - development
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821071
---
User accounts are represented by YAML files in the `users/` directory, named according to their email address. The YAML contents must have a password and role of some kind inside to be able to log into the control panel. The simplest role is a Super User.

:::tip
You can also [create users via the command line](/quick-start#create-your-first-user). It's even easier than this.
:::

## Walkthrough: Creating a new Super User

1. Create a file called `<your.email@example.com.yaml>`. Make sure to use a real email address otherwise that reset password feature won't do a darn thing.
2. Inside the YAML file add `super: true` and `password: anything_you_want`, where `anything_you_want` is literally anything you want as a password.
3. Visit any URL on the site and Statamic will spot that unencrypted password and hash/securify it for you.
4. Now you can log in with `anything_you_want`, or the thing you really wanted.

**Before being securified:**
``` yaml
# your.email@example.com.yaml
super: true
password: anything_you_want
```

**After securification:**
``` yaml
# your.email@example.com.yaml
super: true
password_hash: $2y$10$Vopn8T7e.EMVEjxdP5p.g.AU5GTTN4RklvgR2l0dTwSPeJal91v/q
```

## Assigning Non-Super Roles

If you've created roles with limited permissions, you can assign those to your user's YAML file in an array:

``` yaml
roles:
  - editor
  - publisher
```
