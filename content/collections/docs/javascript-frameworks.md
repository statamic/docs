---
id: 131259a5-2072-49d8-9ea4-2099e0338e2f
blueprint: page
title: 'JavaScript Frameworks'
intro: 'There are many different approaches you could take to pass data to JavaScriptLand. Here are some suggestions on how to fetch, format, and hydrate (inject data) typical JavaScript components.'
template: page
nav_title: 'Front-End Frameworks'
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1632512027
---
The examples below use [Vue.js](https://vuejs.org/) as the framework of choice, but these techniques will apply to most JavaScript frameworks.

## Pass all page data directly to a component
This is probably the simplest possible method. You can encode all the page data into JSON and inject it directly into your component. The downside is that you'll be exposing all that data to the client-side, if that's a concern for your particular site.

::tabs

::tab antlers
```antlers
<home-page
  :page-data="{{ page | to_json | entities }}">
</home-page>
```
::tab blade
```blade
<home-page
  :page-data="{{ Statamic::modify($page)->toJson() }}">
</home-page>
```
::


## Assemble selective JSON inside Antlers/Blade and pass to components via props
This method is simple, best used for one-off situations. It provides you control over exactly what data you want to pass to your components, but is too messy to be used at a larger scale.

::tabs

::tab antlers
```antlers
<home-page
  :navigation="[
   {{ nav:main_navigation }}
      {
        title: '{{ title }}',
        slug: '{{ url }}',
        id: '{{ id }}'
      },
   {{ /nav:main_navigation }}
 ]"
></home-page>
```
::tab blade
```blade
<home-page
  :navigation="[
   @foreach (Statamic::tag('nav:main_navigation') as $navPage)
      {
        title: '{{ $navPage['title'] }}',
        slug: '{{ $navPage['url'] }}',
        id: '{{ $navPage['id'] }}'
      },
   @endforeach
 ]"
></home-page>
```
::

## Fetching data from a collection
This method is used to fetch _any_ entry-based data, not just that available on the current page.

```vue
<home-page
  :footer-data="{{ footer as='entry' }}{{ entry | to_json | entities }}{{ /footer }}">
</home-page>
```

:::tip
[Live Preview](/live-preview) only has the current page's data available to it. Trying to query collection data **will not work**.
:::

## The Content API
[The Content REST API](/rest-api) can be used on its own, or in conjunction with the above methods.

Here is a simple example component that fetches data using the asynchronous `created()` function. This data can then be used in the component or passed down to child components. The example uses the standard `Fetch` method but you can use any AJAX library (Axios, etc).

```vue
<template>
  <section v-if="pageData">
    <div>
      {{ pageData.title }}
      {{ pageData.content }}
    </div>
  </section>
</template>

<script>
  export default {
    data() {
      return {
        pageData: null,
      }
    },
    async created() {
      try {
        const res = await fetch('/api/collections/pages/entries/home'); // Get the data from the API
        const { data } = await res.json() // Convert it to JSON
        this.pageData = data; // Assign the data to the component Data
      } catch (e) {
        // Handle your errors
      }
    }
  }
</script>
```

## Custom view models
It is also possible to create [a view model](/view-models) which will return only the data you require. However, this requires PHP knowledge.
