---
title: 'Using Front-End Frameworks'
intro: 'There are quite a few methods of passing data to your components. We''ll show you how to utilize some of the methods available within Statamic to get the data you need, and how to format it correctly so you can use it in your front-end components.'
template: page
stage: 'Needs Polish & Humor'
nav_title: 'Front-End Frameworks'
updated_by: 00e54795-ff8f-4be5-af67-3254d7c269a7
updated_at: 1613922784
id: 131259a5-2072-49d8-9ea4-2099e0338e2f
---
The examples below are demonstrating how this works in context with [Vue JS](https://vuejs.org/) - but this methodology also applies to other frameworks.

## Manually building JSON in antlers to pass to components
This method is not very scalable but does give you control over exactly what data you want to send to your components.

```vue
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

## Passing the available data of the page directly to a component
This is the simplest method available, we will simply pass all of the page data directly to your component.

```vue
<home-page
  :page-data="{{ page | to_json | entities }}">
</home-page>
```

## Fetching data from a collection
This method is used to fetch data that is not available on your current page.

```vue
<home-page
  :footer-data="{{ footer as='entry' }}{{ entry | to_json | entities }}{{ /footer }}">
</home-page>
```

> Note that when using [the Live Preview feature](https://statamic.dev/live-preview), only the current page data is available to you. Trying to query collection data **will not work**.

## The Content API
[The Content API](https://statamic.dev/content-api) can be used on its own or in conjunction with the above methods. 
Below we show a simple example component, which fetches the data in it's (async) created function. This data can then be used in the component or passed down to child components.
The example uses the standard Fetch method but you can use any AJAX library.

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
        this.pageData = data; // Assign the data to the components Data
      } catch (e) {
        // Handle your errors
      }
    }
  }
</script>
```

## Custom View Models
It is also possible to create [a view model](https://statamic.dev/view-models) which will return only the data you require. However, this requires PHP knowledge.