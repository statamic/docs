---
id: b47a6f6c-37bf-4269-9930-9096ee21891a
blueprint: tips
title: 'Disabling Control Panel Authentication'
intro: 'BYO login page.'
template: page
---
In some cases, you may want to disable the Control Panel's authentication pages (login, forgot password, etc.) This could be handy if you are building that part of your app yourself.

1. In `config/statamic/cp.php`, disable the authentication features.
   ```php
   'auth' => [
     'enabled' => false,
     'redirect_to' => '/your-login-page'
   ]
   ```

The Control Panel will still require an authorized user. This just allows you to provide your own login flow.
