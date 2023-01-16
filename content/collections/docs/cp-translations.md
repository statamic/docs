---
title: 'Control Panel Translations'
nav_title: Translations
intro: "Statamic's Control Panel is currently available in 18 languages. We always welcome new translations!"
blueprint: page
id: 79129d32-3f7c-4215-b6b1-21a2fccafa8d
---
## Configuration

Set which language you want to use by default in `config/app.php`. You may also choose a fallback locale in case new content and strings are added to the control panel before an accompanying translation has been updated.

``` php
'locale' => 'es',
'fallback_locale' => 'en',
```

### Per-User Override

You can override the translation locale on a per-user basis by setting `locale: {code}` in a given user's preferences (their YAML record).

``` yaml
#  users/nosmo.king@example.com
name: Nosmo King
super: true
preferences:
  locale: en
```

### Available Translations

| Language | Code |
|----------|------|
| Czech | `cs` |
| Danish | `da` |
| German | `de` or `de_CH` |
| English | `en` |
| Spanish | `es` |
| French | `fr` |
| Hungarian | `hu` |
| Indonesia | `id` |
| Italian | `it` |
| Malaysia | `ms` |
| Norwegian | `nb` |
| Dutch | `nl` |
| Polish | `pl` |
| Portuguese | `pt` |
| Russia | `ru` |
| Slovene | `sl` |
| Swedish | `sv` |
| Taiwan | `zh_TW` |
| Turkish | `tr` |

_Translations are community contributed so may you find them to be incomplete shortly after an update._

## Contributing a New Translation

There are 4 steps.

1. Clone [`statamic/cms`](https://github.com/statamic/cms) locally
2. Run `composer install`
3. Generate a new translation from source files
4. Translate new message files in `resources/lang`
5. Commit changes and submit a PR

### Generating Translation Files

Run the `translator generate` command in the `statamic/cms` project, along with the new language code as an argument. This will generate empty JSON and PHP files in `resources/lang` ready to be translated into the locale of your choice.

You can specify a short 2 character language code (`es`) or the full 4 character regional code (`es_MX`). 

_It is recommended that you comply to the [`language code standard`](https://www.science.co.il/language/Codes.php)._

``` shell
php translator generate eo
```

- The JSON file contains all the "short strings" established on the fly with the translation helpers, e.g. `__('Cowabunga')`.
- The PHP files contain longer strings and are well organized by section of the control panel.
- Translatable strings can contain a `|` to separate singular and plurals.
- Translatable strings can contain the `:something` format to indicate a variable.

``` files theme:serendipity-light
resources/lang/
|-- eo/
|   |-- markdown.php
|   |-- messages.php
|   |-- permissions.php
|   |-- validation.php
|-- eo.json
```

#### Using Google Translate

You can get a translation kickstarted with the Google API by passing your API key.

``` shell
php translator generate eo --key=abc123
```

### Using the Reviewer

Running the `translator review` command will loop through all the translations showing you the key, the English phrase, and new translated phrase for proofreading. You can enter new translations during this process. You can also use this command to gather new or changed translatable strings after a Statamic update.

``` shell
php translator review eo messages
```
