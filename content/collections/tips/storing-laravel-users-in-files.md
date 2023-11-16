---
id: 748f88ce-85f6-491b-8e9c-fa2b1895be31
title: 'Storing Laravel Users in Files'
intro: 'Sometimes the Statamic way overrules the Laravel way.'
template: page
categories:
  - development
  - laravel
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821304
---
When creating new site using the `statamic` command or by cloning `statamic/statamic`, your Laravel application will be preconfigured
to store users as files. Nothing else is required!

If you've installed Statamic into an existing Laravel application, it will be expecting users to be stored in the database, but you can switch to the filesystem:

1. In `config/statamic/users.php`, change `repository` to `file`.
2. In `config/auth.php`, change the users provider driver to `statamic`.
   ``` php
    'providers' => [
        'users' => [
            'driver' => 'statamic',
        ],
    ],
   ```