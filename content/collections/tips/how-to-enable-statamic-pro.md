---
id: 142626de-5984-4600-b14b-2a753d6979a8
blueprint: tips
title: 'How to Enable Statamic Pro'
intro: 'A fresh Statamic install starts in Solo edition mode. Here''s how to enable Pro mode and unlock every feature Statamic has.'
template: page
---
A fresh Statamic install starts in Solo edition mode. You can enable Pro at any time in your `config/statamic/editions.php` file:

``` php
'pro' => true,
```

Once you've opted in, many additional features become be available.

## Trying Pro Mode {#trial-mode}

You can use Statamic Pro locally without a license key for as long as you'd like. This is called **Trial Mode**.

While in trial mode you are also able to try out any commercial [addons](https://statamic.com/addons).

## When It's Time to Launch

Once it’s time to launch your site on a public domain, there are a few things you need to do:

- [Create a Site](#sites) on statamic.com and enter the appropriate domain(s).
- Purchase a license of [Statamic Pro](https://statamic.com/pricing) (and any paid addons) and attach them to your Site.
- Add your Site's license key to your environment file in production.

``` env
STATAMIC_LICENSE_KEY=your-site-license-key
```

