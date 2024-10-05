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
