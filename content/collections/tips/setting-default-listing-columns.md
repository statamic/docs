---
id: 62656a00-d225-4906-8387-de780476497e
title: 'Setting Default Listing Columns'
intro: ''
template: page
categories:
  - development
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1700749977
---
Statamic allows you to configure "default preferences" which will apply to all users. This allows you to configure the columns & the order those columns are shown by default in the listing tables.

There's currently no UI for setting default preferences for the listing tables. However, it's easy to do if you're prepared to wrangle with some friendly YAML files.

1. First, go to the relevant collections in the Control Panel and use the "column picker" (shown below) to configure which columns should show. You can re-order columns too.

<figure>
    <img src="/img/tips/customize-columns.png" alt="Columns customizer">
</figure>

You should repeat this step for any other collections or taxonomies you want to set default columns for.

2. Once you're happy, open your user's YAML file. You'll see a `preferences` key containing the columns you just configured:

```yaml
preferences:
  collections:
    articles:
      columns:
        - title
        - date
        - status
```

If you're [storing users in a database](/tips/storing-users-in-a-database), you'll need to convert the JSON found in the `preferences` column of your `users` table to YAML. You can use a service like [json2yaml.com](https://json2yaml.com/) to convert your preferences from JSON to YAML.

3. Next, you'll want to create a new file: `resources/preferences.yaml`. Copy everything from inside the `preferences` array into this new file so it looks similar to this:

```yaml
collections:
  articles:
    columns:
      - title
      - date
      - status
```

4. Finally, if you clear your own `preferences` or login as another user, you should be using the default columns you just configured. 🎉
