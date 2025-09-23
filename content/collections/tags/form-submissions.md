---
title: "Form:Submissions"
id: afa2740e-2cf7-4ada-a92e-4fc92e827351
description: Fetches data from form submissions.
intro: This is how you fetch data and display data from form submissions. It works very much like the [collection](/tags/collection) tag.
parameters:
  -
    name: handle|is|in|form|formset
    type: string
    description: >
      Specify the name of the form. Only required if you do _not_ use the `form:set` tag, or don't have a `form` defined in the current context.
  -
    name: sort
    type: string
    description: 'Sort form submissions by field name (or `random`). You may pipe-separate multiple fields for sub-sorting and specify sort direction of each field using a colon. For example, `sort="name"` or `sort="date:asc|name:desc"` to sort by date then by name.'
    required: false
  -
    name: limit
    type: integer
    description: 'Limit the total results returned.'
    required: false
  -
    name: filter|query_scope
    type: string
    description: "Apply a custom [query scope](/extending/query-scopes-and-filters) You should specify the query scope's handle, which is usually the name of the class in snake case. For example: `MyAwesomeScope` would be `my_awesome_scope`."
    required: false
  -
    name: offset
    type: integer
    description: 'Skip a specified number of results.'
    required: false
  -
    name: paginate
    type: 'boolean|int *false*'
    description: 'Specify whether your form submissions should be paginated. You can pass `true` and also use the `limit` param, or just pass the limit directly in here.'
    required: false
  -
    name: page_name
    type: 'string *page*'
    description: 'The query string variable used to store the page number (ie. `?page=`).'
    required: false
  -
    name: on_each_side
    type: 'int *3*'
    description: When using pagination, this specifies the max number of links each side of the current page. The minimum value is `1`.
  -
    name: as
    type: string
    description: 'Alias your form submissions into a new variable loop.'
    required: false
  -
    name: scope
    type: string
    description: 'Scope your form submissions with a variable prefix.'
    required: false
variables:
  -
    name: submission data
    type: mixed
    description: Each submission has access to all the submitted data.
  -
    name: date
    type: Carbon object
    description: Along with the submission data, all submissions will contain the date they were submitted.
  -
    name: no_results
    type: boolean
    description: >
      `true` if no results.
  -
    name: total_results
    type: integer
    description: The total number of results, if any.
stage: 4
---

## Example

::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" }}
    <div>
        Submitted on {{ date }}<br>
        Name: {{ name }}<br>
        Rating: {{ rating }}<br>
        Comment: {{ comment }}
    </div>
{{ /form:submissions }}
```
::tab blade
```blade
{{-- Without aliasing. --}}
<s:form:submissions
  in="feedback"
>
  <div>
    Submitted on {{ $date }}<br>
    Name: {{ $name }}<br>
    Rating: {{ $rating }}<br>
    Comment: {{ $comment }}
  </div>
</s:form:submissions>

{{-- With aliasing --}}
<s:form:submissions
  in="feedback"
  as="submissions"
>
  @foreach ($submissions as $submission)
    <div>
      Submitted on {{ $submission->date }}<br>
      Name: {{ $submission->name }}<br>
      Rating: {{ $submission->rating }}<br>
      Comment: {{ $submission->comment }}
    </div>
  @endforeach
</s:form:submissions>
```
::

## Filtering

There are a number of ways to filter your submissions. There's the conditions syntax for filtering by fields and the custom filter class if you need extra control.

### Conditions

Want to get entries where the title has the words "awesome" and "thing", and "joe" is the author? You can write it how you'd say it:

::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" name:contains="David" email:contains="gmail.com" }}
```
::tab blade
```blade
<s:form:submissions
  in="feedback"
  name:contains="David"
  email:contains="gmail.com"
>

</s:form:submissions>
```
::

There are a bunch of conditions available to you, like `:is`, `:isnt`, `:contains`, `:starts_with`, and `:is_before`. There are many more than that. In fact, there's a whole page dedicated to [conditions - check them out][conditions].

### Custom Query Scopes

Doing something custom or complicated? You can create [query scopes](/extending/query-scopes-and-filters) to narrow down those results with the `query_scope` or `filter` parameter:


::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" query_scope="your_query_scope" }}
```
::tab blade

```blade
<s:form:submissions
  in="feedback"
  query_scope="your_query_scope"
>

</s:form:submissions>
```
::

You should reference the query scope by its handle, which is usually the name of the class in snake case. For example: `YourQueryScope` would be `your_query_scope`.

## Pagination


To enable pagination mode, add the `paginate` parameter with the number of submissions in each page.

::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" paginate="10" as="comments" }}

    {{ if no_results }}
        <p>Aww, there are no results.</p>
    {{ /if }}

    {{ comments }}
        <article>
            Feedback from {{ name }}
        </article>
    {{ /comments }}

    {{ paginate }}
        <a href="{{ prev_page }}">⬅ Previous</a>

        {{ current_page }} of {{ total_pages }} pages
        (There are {{ total_items }} submissions)

        <a href="{{ next_page }}">Next ➡</a>
    {{ /paginate }}

{{ /form:submissions }}
```
::tab blade
```blade
<s:form:submissions
  in="feedback"
  paginate="10"
  as="comments"
>
  @if ($no_results)
    <p>Aww, there are now results.</p>
  @endif

  @foreach ($comments as $comment)
    <article>
      Feedback from {{ $comment->name }}
    </article>
  @endforeach

  @if ($paginate['total_pages'] > 1)
    <a href="{{ $paginate['prev_page'] }}">⬅ Previous</a>

    {{ $paginate['current_page'] }} of {{ $paginate['total_pages'] }} pages
    (There are {{ $paginate['total_items'] }} submissions)

    <a href="{{ $paginate['next_page'] }}">Next ➡</a>
  @endif
</s:form:submissions>
```
::

In pagination mode, your submissions will be scoped (in the example, we're scoping them into the `comments` tag pair). Use that tag pair to loop over the entries in that page.

The `paginate` variable will become available to you. This is an array containing data about the paginated set.

| Variable | Description |
|----------|-------------|
| `next_page` |	The URL to the next paginated page.
| `prev_page` |	The URL to the previous paginated page.
| `total_items` | The total number of submissions.
| `total_pages` |  number of paginated pages.
| `current_page` | The current paginated page. (ie. the x in the ?page=x param)
| `auto_links` | Outputs an HTML list of paginated links.
| `links` |	Contains data for you to construct a custom list of links.
| `links:all` |	An array of all the pages. You can loop over this and output {{ url }} and {{ page }}.
| `links:segments` | An array of data for you to create a segmented list of links.

<br>

### Pagination Examples

The `auto_links` tag is designed to be your friend. It'll save you more than a few keystrokes, and even more headaches. It will output an HTML list of links for you. With a large number of pages, it will create segments so that you don't end up with hundreds of numbers.

It's clever enough to work out a comfortable range of numbers to display, and it'll also throw in the prev/next arrow for good measure.

Maybe the default markup isn't for you and you want total control. You're a maverick. That's cool, we roll that way sometimes too. That's where the `links:all` or `links:segments` array variables come in. These give you all the data you need to recreate your own set of links.

- The `links:all` array is _all_ the pages with `url` and `page` variables.

- The `links:segments` array will contain the segments mentioned above. You'll be able to access `first`, `slider`, and `last`, which are the 3 segments.

Here's the `auto_links` output, recreated using the other tags, for you mavericks out there:

::tabs

::tab antlers
```antlers
{{ paginate }}
    <ul class="pagination">
        {{ if prev_page }}
            <li><a href="{{ prev_page }}">&laquo;</a></li>
        {{ else }}
            <li class="disabled"><span>&laquo;</span></li>
        {{ /if }}

        {{ links:segments }}

            {{ first }}
                {{ if page == current_page }}
                    <li class="active"><span>{{ page }}</span></li>
                {{ else }}
                    <li><a href="{{ url }}">{{ page }}</a></li>
                {{ /if }}
            {{ /first }}

            {{ if slider }}
                <li class="disabled"><span>...</span></li>
            {{ /if }}

            {{ slider }}
                {{ if page == current_page }}
                    <li class="active"><span>{{ page }}</span></li>
                {{ else }}
                    <li><a href="{{ url }}">{{ page }}</a></li>
                {{ /if }}
            {{ /slider }}

            {{ if slider || (!slider && last) }}
                <li class="disabled"><span>...</span></li>
            {{ /if }}

            {{ last }}
                {{ if page == current_page }}
                    <li class="active"><span>{{ page }}</span></li>
                {{ else }}
                    <li><a href="{{ url }}">{{ page }}</a></li>
                {{ /if }}
            {{ /last }}

        {{ /links:segments }}

        {{ if next_page }}
            <li><a href="{{ next_page }}">&raquo;</a></li>
        {{ else }}
            <li class="disabled"><span>&raquo;</span></li>
        {{ /if }}
    </ul>
{{ /paginate }}
```
::tab blade
```blade
<s:form:submissions
  in="feedback"
  paginate="10"
  as="comments"
>
  // ...

  @if ($paginate['total_pages'] > 1)
    @php
        $hasSlider = count($paginate['links']['segments']['slider']) > 0;
        $hasLast = count($paginate['links']['segments']['last']) > 0;
    @endphp

    <ul class="pagination">
      @if ($paginate['prev_page'])
        <li><a href="{{ $paginate['prev_page'] }}">&laquo;</a></li>
      @else
        <li class="disabled"><span>&laquo;</span></li>
      @endif

      @foreach (Arr::get($paginate, 'links.segments.first', []) as $segment)
        @if ($segment['page'] == $paginate['current_page'])
          <li class="active"><span>{{ $segment['page'] }}</span></li>
        @else
          <li><a href="{{ $segment['url'] }}">{{ $segment['page'] }}</a></li>
        @endif
      @endforeach

      @if ($hasSlider)
        <li class="disabled"><span>...</span></li>
      @endif

      @foreach (Arr::get($paginate, 'links.segments.slider', []) as $segment)
        @if ($segment['page'] == $paginate['current_page'])
          <li class="active"><span>{{ $segment['page'] }}</span></li>
        @else
          <li><a href="{{ $segment['url'] }}">{{ $segment['page'] }}</a></li>
        @endif
      @endforeach

      @if ($hasSlider || $hasLast)
        <li class="disabled"><span>...</span></li>
      @endif

      @foreach (Arr::get($paginate, 'links.segments.last', []) as $segment)
        @if ($segment['page'] == $paginate['current_page'])
          <li class="active"><span>{{ $segment['page'] }}</span></li>
        @else
          <li><a href="{{ $segment['url'] }}">{{ $segment['page'] }}</a></li>
        @endif
      @endforeach

      @if ($paginate['next_page'])
        <li><a href="{{ $paginate['next_page'] }}">&raquo;</a></li>
      @else
        <li class="disabled"><span>&raquo;</span></li>
      @endif
    </ul>
  @endif
</s:form:submissions>
```
::

## Aliasing {#alias}

Often times you'd like to have some extra markup around your list of submissions, but only if there are results. Like a `<ul>` element, for example. You can do this by _aliasing_ the results into a new variable tag pair. This actually creates a copy of your data as a new variable. It goes like this:

::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" as="comments" }}
    <ul>
      {{ comments }}
        <li>
            Feedback from {{ name }}
        </li>
      {{ /comments }}
    <ul>
{{ /form:submissions }}
```
::tab blade
```blade
<s:form:submissions
  in="feedback"
  as="comments"
>
  <ul>
    @foreach ($comments as $comment)
    <li>
      Feedback from {{ $comment->name }}
    </li>
    @endforeach
  </ul>
</s:form:submissions>
```
::

## Scoping {#scope}

Sometimes not all of your submissions have the same set of variables. And sometimes the page that you're on may have those very same variables on the page-level scope. Statamic assumes you'd like to fallback to the parent scope's data to plug any holes. This logic has pros and cons, and you can [read more about scoping and the Cascade here](/cascade).

You can assign a _scope_ prefix to your submissions so you can be sure to get the data you want. Define your scope and then prefix all of your variables with it.

```yaml
# Page data
featured_image: /img/totes-adorbs-kitteh.jpg
```

::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" scope="comment" }}
  <div class="block">
    {{ comment:name }}
  </div>
{{ /form:submissions }}
```
::tab blade
```blade
<s:form:submissions
  in="feedback"
  scope="comment"
>
   <div class="block">
     {{ $comment->name }}
   </div>   
</s:form:submissions>
```
::

You can also add your scope down into your [alias](#alias) loop. Yep, we thought of that too.

::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" as="comments" }}
  {{ comments scope="comment" }}
    <div class="block">
      {{ comment:name }}
    </div>
  {{ /comments }}
{{ /form:submissions }}
```
::tab blade
```blade
<s:form:submissions
  in="feedback"
  as="comments"
>
  @foreach ($comments as $comment)
  <div class="block">
    {{ $comment->name }}  
  </div>
  @endforeach
</s:form:submissions>
```
::

Combining both an Alias and a Scope on the Form Submissions Tag doesn't make a whole lot of sense. You shouldn't do that.

## Grouping

To group submissions – by date or any other field – you should use [aliasing](#alias) (explained above) as well as the [`group_by`](/modifiers/group_by) modifier.
There's no "grouping" feature on the submissions tag itself.

For example, if you want to group some dated submissions by month/year, you could do this:

::tabs

::tab antlers
```antlers
{{ form:submissions in="feedback" as="comments" }}
  {{ comments group_by="date|F Y" }}
    {{ groups }}
        <h3>{{ group }}</h3>
        {{ items }}
            {{ title }} <br>
        {{ /items }}
    {{ /groups }}
  {{ /comments }}
{{ /form:submissions }}
```
::tab blade
```blade
<s:form:submissions
  in="feedback"
  as="comments"
>
  @php
  $groupedSubmissions = $comments->groupBy(fn($$comment) => $entry->comment?->format('F Y'));
  @endphp

  @foreach ($groupedSubmissions as $group => $items)
    <h3>{{ $group }}</h3>

    @foreach ($items as $comment)
      {{ $comment->title }}
    @endforeach
  @endforeach
</s:form:submissions>
```
::


[conditions]: /conditions
