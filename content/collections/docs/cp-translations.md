---
title: 'Control Panel Translations'
nav_title: Translations
intro: "Statamic's Control Panel is currently available in 6 languages. We always welcome new translations!"
stage: 4
id: 79129d32-3f7c-4215-b6b1-21a2fccafa8d
---
## Configuration

Set which language you want to use by default in `config/app.php`. You may also choose a fallback locale in the event that new content and strings are added to the control panel before an accompanying translation has been updated.

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
| English | `en` |
| French | `fr` |
| German | `de` |
| Italian | `it` |
| Portuguese | `pt` |
| Spanish | `es` |

_Transations are community contributed so may you find them to be incomplete shortly after an update._

## Contributing a New Translation

There are 4 steps.

1. Clone [`statamic/cms`](https://github.com/statamic/cms) locally
2. Generate a new translation from source files
3. Translate new message files in `resources/lang`
4. Commit changes and submit a PR

### Generating Translation Files

Run the `translator generate` command in the `statamic/cms` project, along with the new language code as an argument. This will generate empty JSON and PHP files in `resources/lang` ready to be translated into the locale of your choice.

You can specify a short 2 character language code (`es`) or the full 4 character regional code (`es-MX`).

``` bash
php translator generate eo
```

- The JSON file contains all the "short strings" established on the fly with the tranlation helpers, e.g. `__('Cowabunga')`.
- The PHP files contain longer strings and are well organized by section of the control panel.

``` files
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

``` bash
php translator generate eo --key=abc123
```

### Using the Reviewer

Running the `translator review` command will loop through all the translations showing you the key, the English phrase, and new translated phrase for proofreading. You can enter new translations during this process.

``` bash
php translator review eo messages
```
