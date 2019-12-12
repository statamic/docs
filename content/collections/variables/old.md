---
types:
  - system
id: a1d6bfec-e0dd-45a5-9c9e-200d700de244
---
An array of sanitized variables POSTed from the previous request.

In certain forms – for example, `{{ user:login_form }}` – you may encounter validation errors that will require you to resubmit your the form.

Instead of making your users re-type everything, you may use `{{ old:[field_name] }}` tag to display their previously-entered input values.

When using the `{{ user:login_form }}` to login, upon entering incorrect credentials, you will be shown the same page. You can use the `{{ old:[field_name] }}` tags to maintain the values like so:

```
{{ user:login_form }}

    {{ if errors }}
        ...
    {{ /if }}


    <label>Username</label>
    <input type="text" name="username" value="{{ old:username }}" />

    <label>Password</label>
    <input type="password" name="password" value="{{ old:password }}" />

    <button>Log in</button>

{{ /user:login_form }}
```
