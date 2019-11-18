---
title: Routing
template: page
updated_by: 3a60f79d-8381-4def-a970-5df62f0f5d56
updated_at: 1568558573
id: 8d9cfb16-36bf-45d0-babb-e501a35ddae6
blueprint: page
---
## Statamic routing

Any requests to your site will be handled by Statamic (unless you [create your own Laravel routes](#laravel-routing)).

## Data routing

Entries and taxonomy terms will have their own dedicated URLs if you defined a route in their respective collection or taxonomy yaml files.

Same syntax as v2.

## Template routes

Same as v2, except they live in `config/statamic/routes.php`.

### Content types 

Same as v2. Add `'content_type' => 'application/json'` to serve `application/json`. The shorthands are there too. `json` becomes `application/json`.

## Redirects

Same as v2, except they live in `config/statamic/routes.php`.


## Laravel routing

You're free to configure your own regular Laravel routes like you would in a regular app. Plop them in your `routes/web.php` file. Use closures, or point to a [controller](/controllers). Again, this is just [standard Laravel stuff](https://laravel.com/docs/6.x/routing). 

## Error pages

Whenever an error is encountered, a view will be rendered based on the status code. It will look for the view in `resources/views/errors/{status}.antlers.html`.

Your standard layout will be used. You can use a custom layout for errors by making sure a `layout.antlers.html` exists in the errors directory.

Statamic will automatically render 404 pages for any unhandled routes.