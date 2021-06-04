---
id: 1ee69ba0-2fa4-4155-9b8d-82536ce95f99
title: 'Storing Users Somewhere Custom'
intro: 'Sometimes you just gotta be special.'
template: page
categories:
  - database
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1622821332
---
If you'd like to store your users somewhere outside the filesystem, and the included Eloquent implementation doesn't quite cut it for you,
you're free to write your own.

You will need to write implementations for all the contracts located in `Statamic\Contracts\Auth`. Of course, you may extend the native classes and override where appropriate, instead of writing everything from scratch.

In a service provider, use the `Statamic\Facades\User::repository()` method to define a custom repository driver:

``` php
Statamic\Facades\User::repository('custom', function ($app, $config) {
    return new CustomUserRepository;
});
```

After you've registered the driver using the `repository` method, you'll want to create a repository in `config/statamic/users.php` that uses the new driver:

``` php
'repositories' => [
    'custom' => [
        'driver' => 'custom',
    ]
]
```

Finally, set that repository as the one you want active:

``` php
'repository' => 'custom'
```
