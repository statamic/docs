---
id: dc9c535d-59ac-475d-af4f-a0204a71f31b
types:
  - system
---
An array of sanitized `POST` variables that come from any form data present for a POST to the current URL. It can be used as a tag pair with access to all your data or as a single tag to access variables directly. A counterpart to `{{ get }}`.

```
<form method="post">
  <input type="hidden" name="_token" value="csrftokenhere" />
  <input type="text" name="first_name" value="Niles">
  <input type="text" name="last_name" value="Peppertrout">
  <button>Submit</button>
</form>
```

```
{{ post }}
  {{ first_name }} {{ last_name }}
{{ /post }}

Mr. {{ post:last_name }}
```

``` .language-output
Niles Peppertrout

Mr. Peppertrout
```
