---
id: 62656a00-d225-4906-8387-de780476497e
title: 'Setting Default Columns on Listing Tables'
intro: ''
template: page
categories:
  - development
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1700749977
---
Statamic allows you to configure "default preferences" that apply to all users. This enables you to specify the columns and the default order they are shown in on the Listing Tables.

Currently, there's no UI for setting default preferences for the listing tables. However, you can easily do this by modifying some friendly YAML files.

1. First, find the relevant listing table and click the "Customize Columns" button. It'll open up a modal, enabling you to specify the columns you want to show in the listing table. You can re-order columns from here too.

<figure>
    <img src="/img/tips/customize-columns.png" alt="Columns customizer">
</figure>

Repeat this step for any other collections or taxonomies you want to set default columns for.

2. Once you're happy, open your user's YAML file. You'll find a `preferences` key containing the columns you just specified:

```yaml
preferences:
  collections:
    articles:
      columns:
        - title
        - date
        - status
```

If you're [storing users in a database](/tips/storing-users-in-a-database), you'll need to convert the JSON data from the `preferences` column in your `users` table to YAML. You can use an app like [JSON to YAML](https://www.bairesdev.com/tools/json2yaml/) to do this.

3. Next, create a new file called `resources/preferences.yaml`. Copy the contents of the `preferences` array into this new file, resulting in it looking pretty similar to this:

```yaml
collections:
  articles:
    columns:
      - title
      - date
      - status
```

4. Finally, if you clear your user's `preferences` array or login as a different user, the default columns will be displayed just as you specified them. 🎉
