---
id: 66edce16-321a-4e94-8e71-44c1ae7b934e
blueprint: tips
title: 'Enforce trailing slashes in URLs'
---
If you're moving from another CMS that uses trailing slashes in URLs and you'd like to keep the same format in Statamic for SEO purposes, you can!

Simply add this to the `boot` method of your `AppServiceProvider`:

```php
use Statamic\Facades\URL;

URL::enforceTrailingSlashes()
```

Now all URLs built by Statamic will include trailing slashes.

## Redirect

This only handles how Statamic builds URLs. Statamic will still accept requests to non-trailing-slash URLs. If you want them to redirect to the trailing slash version, add the following to your web server config:

### Apache

Add this to your `.htaccess` file:

```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !(.*)/$
RewriteRule ^(.*)$ /$1/ [R=308,L]
```

### Nginx

Add this to your `server` block:

```
location / {
    if ($request_uri ~ "^[^?\\.]*[^/]$") {
        return 308 $request_uri/;
    }
    try_files $uri $uri/ /index.php?$query_string;
  }
```

### IIS

Add this to your `web.config` file:

```
<system.webServer>
    <rewrite>
        <rules>
            <rule name="Add trailing slash" stopProcessing="true">
                <match url="^([^/]+(?:/[^/]+)*)$" />
                <conditions>
                    <add input="{REQUEST_FILENAME}" matchType="IsFile" negate="true" />
                    <add input="{REQUEST_FILENAME}" matchType="IsDirectory" negate="true" />
                </conditions>
                <action type="Redirect" url="{R:1}/" redirectType="Permanent308" />
            </rule>
        </rules>
    </rewrite>
</system.webServer>
```