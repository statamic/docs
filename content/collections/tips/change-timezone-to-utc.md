---
id: 7af5ee6c-234a-48eb-b02b-c72b52562618
blueprint: tips
title: 'How to change your timezone to UTC'
intro: "Statamic 6 introduces improved timezone handling. Using UTC as your timezone is a best practice."
template: page
related_entries:
  - 7dfba904-8a74-40e1-b507-51cd2b5f6123
---
It's best practice to keep your app's timezone set to UTC.

If you've had to change it in the past (maybe to workaround timezone issues in Statamic), you may now change it back to UTC.

:::warning
Before continuing, you will want to make a backup of your content and/or database.

Additionally, you may consider **not** changing your timezone for existing sites. While it is a best practice, it's not a requirement. 
:::

## Migration command
You can use our migration command which will update date fields throughout your content:

```bash
php please migrate-dates-to-utc America/New_York
```

You should replace `America/New_York` with whatever timezone you want to convert dates _from_ (e.g. your old app timezone).

If you're storing content in a database, or outside of version control, you will need to run this command after deploying to production/staging.

Once complete, you may change your app's timezone in `config/app.php`:

```php
// config/app.php

'timezone' => 'America/New_York', // [tl! remove]
'timezone' => 'UTC', // [tl! add]
```
