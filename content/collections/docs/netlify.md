---
id: 7f809a5e-e555-4ccc-8488-d7310ff8c89c
blueprint: page
title: 'Deploying Statamic to Netlify'
parent: c4f17d05-78bd-41bf-8e06-8dd52f6ec154
---
Deployments are triggered by committing to Git and pushing to GitHub.

- Create a site in your [Netlify](https://netlify.com) account
- Link the site to your desired GitHub repository
- Add build command `php please ssg:generate` (if you need to compile css/js, be sure to add that command too and execute it before generating the static site folder. e.g. `npm install && npm run prod && php please ssg:generate`).
- Set publish directory `storage/app/static`

After your site has an APP_URL...

- Set it as an environment variable. Add `APP_URL` `https://thats-numberwang-47392.netlify.com`

Finally, generate an `APP_KEY` to your .env file locally using `php artisan key:generate` and copy it's value, then...

- Set it as an environment variable. Add `APP_KEY` `[your app key value]`

#### S3 Asset Containers

If you are storing your assets in an S3 bucket, the `.env`s used will need to be different to the defaults that come with Laravel, as they are reserved by Netlify. For example, you can amend them to the following:

```sh
# .env
AWS_S3_ACCESS_KEY_ID=
AWS_S3_SECRET_ACCESS_KEY=
AWS_S3_DEFAULT_REGION=
AWS_S3_BUCKET=
AWS_URL=
```

Be sure to also update these in your `s3` disk configuration:

```php
// config/filesystems.php
's3' => [
    'driver' => 's3',
    'key' => env('AWS_S3_ACCESS_KEY_ID'),
    'secret' => env('AWS_S3_SECRET_ACCESS_KEY'),
    'region' => env('AWS_S3_DEFAULT_REGION'),
    'bucket' => env('AWS_S3_BUCKET'),
    'url' => env('AWS_URL'),
],
```
