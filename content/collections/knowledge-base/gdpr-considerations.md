---
title: 'GDPR Considerations'
intro: 'We aren''t lawyers and this isn''t official advice, but here are some things to consider if you need to comply with [GDPR](https://en.wikipedia.org/wiki/General_Data_Protection_Regulation).'
id: 3859a6bf-8ece-44d0-9a30-4879c93924bf
---
## User Accounts and Git

If you're version controlling everything (which we usually recommend), you may want to consider excluding your users from version control or storing them in a database as references to user data will persist in a git repository's history even after that user is removed from the application.

### Option 1: Gitingore rule

```git
# .gitignore

users/*
```

If you take this approach, your production server will be the single source of truth. You may want to consider having some sort of backup system for the user records. You know, just in case.

### Option 2: Store users in a database

Another option would be to store your users in a database so you can remove them without leaving data fragments behind.

[Here's an article](/knowledge-base/storing-users-in-a-database) on how to do just that.


## Form Submissions

You may also want to disable form submission storing on any [forms](/forms), and opt for email-only notifications.

<figure>
    <img src="/img/knowledge-base/form-disable-store-submissions.png" alt="Form submission storage disabled" width="516">
    <figcaption>You can disable storing form submissions on your server.</figcaption>
</figure>

