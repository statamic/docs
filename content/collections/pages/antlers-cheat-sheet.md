---
id: 0c54fe7c-c87a-4812-b76e-48f16cf08e0d
blueprint: page
title: 'Antlers Cheat Sheet'
intro: "A brief overview of the Antlers features you're likely to use — and a few you may not have known existed."
template: page
related_entries:
  - d37b2af2-f2bf-493a-9345-7087fb5929ce
  - 3d5efc5c-17b1-480b-bb77-53faf3d9552c
  - fbf59081-ba24-4e82-b011-b687be228c89
  - 0574b585-8ed7-4a51-acc4-6f234f8c42e8
  - 74c47654-8c47-49b1-a616-ed940ce19977
  - 5e848460-9bbc-449e-8edd-182d918163ff
  - c7816387-ebc4-4204-b5f2-8e7073a4db8b
---
## Delimiters

| Goal | Antlers {.w-96} |
|------|---------|
| Render a variable, or run an expression | `{{ title }}` |
| Leave a comment | `{{# Replace the lorem ipsum #}}` |
| Run PHP | `{{? $year = now()->year; ?}}` |
| Echo the result of PHP | `{{$ now()->year $}}` |

Expressions are case-sensitive and may break across multiple lines. Use underscores rather than dashes in variable names. See [formatting rules](/frontend/antlers#formatting-rules).

## Reading values

Colon, dot, and bracket notation are interchangeable. Pick one and stay consistent.

| Goal | Antlers {.w-96} |
|------|---------|
| Render a variable | `{{ title }}` |
| Render a literal string | `{{ "Hello" }}` |
| Item at a position (starts at zero) | `{{ sports:0 }}`, `{{ sports.0 }}`, `{{ sports[0] }}` |
| A named key | `{{ address:city }}` |
| Something nested | `{{ he:0:was:a:skater['boy'] }}` |
| A key whose name is in a variable | `{{ address[field] }}` |
| Literal and dynamic keys mixed | `{{ data[3][field]['title'] }}` |
| A property on an object | `{{ $product.name }}` |
| A method on an object | `{{ $product.discounted(20) }}` |
| Drop a value into a string | `{{ "Hi, {name}!" }}` |

Full detail: [plucking](/frontend/antlers#plucking), [associative arrays](/frontend/antlers#dictionaries), [dynamic access](/frontend/antlers#dynamic-access).

## Creating variables

``` antlers
{{# Set a value, then change it #}}
{{ total = 0 }}
{{ total += 1 }}

{{# A list #}}
{{ todo = ['Bake bread', 'Eat soup'] }}

{{# An associative array #}}
{{ person = ['name' => 'Bob', 'age' => 42] }}

{{# ...and reading a key back out #}}
{{ person:name }}

{{# Syntax sugar for creating associative arrays with lots of rows #}}
{{ people = list(name, age;
    'Bob', 42;
    'Amy', 30
) }}

{{# Whatever a tag hands back #}}
{{ items = {collection:products limit="5"} }}

{{# Glue strings together #}}
{{ full_name = first_name + " " + last_name }}

{{# Several statements in one region #}}
{{ a = 1; b = 2; }}
```

:::warning
Array keys must be **literal** strings or numbers. `{{ person = [$key => 'Bob'] }}` will throw an error, and there's no way to build a dynamic key inline at the moment. When the shape isn't known ahead of time, set it up in a [view model](/frontend/view-models). *Reading* a dynamic key is fine: `{{ person[field] }}` works exactly as you'd hope.
:::

When you assign something iterable, the variable name works as a tag pair straight away, with no second step. This is [self-iterating assignment](/frontend/antlers#self-iterating-assignments).

``` antlers
{{ pages = {collection:pages} }}
    {{ title }}
{{ /pages }}
```

More: [creating variables](/frontend/antlers#creating-variables), [concatenation](/frontend/antlers#concatenation), [sub-expressions](/frontend/antlers#sub-expressions).

## Loops

``` antlers
{{# An array of data #}}
{{ songs }}
    {{ value }}
{{ /songs }}

{{# An associative array, when you don't know the keys #}}
{{ foreach:company_info }}
    {{ key }}: {{ value }}
{{ /foreach:company_info }}

{{# Rename key|value if you prefer #}}
{{ foreach:song_reviews as="song|rating" }}
    {{ song }}: {{ rating }}
{{ /foreach:song_reviews }}
```

Inside any loop, these are set for you. There's no `$loop` object to reach for; they're just variables:

| Variable | Meaning |
|----------|-------------|
| `first` / `last` | `true` on the first / last pass |
| `count` | Current pass, starting at `1` |
| `index` | Current pass, starting at `0` |
| `total_results` | How many items there are |
| `no_results` | `true` when there are none |
| `next:` / `prev:` | Reach into the neighboring item, e.g. `{{ next:value }}` |

More: [loop variables](/frontend/antlers#loop-variables), [`{{ foreach }}`](/tags/foreach), [`{{ increment }}`](/tags/increment) for a counter that isn't tied to the loop.

## Conditionals

``` antlers
{{ if logged_in }}
    Welcome back, {{ name }}!
{{ elseif trial_expired }}
    Your trial ended. <a href="/upgrade">Upgrade</a>
{{ else }}
    <a href="/login">Sign in</a>
{{ /if }}

{{# The inverse of if #}}
{{ unless cart }}
    Your cart is empty.
{{ /unless }}

{{# Many branches. Works inside tag parameters, too. #}}
{{ switch(
    (size == 'sm') => '35vw',
    (size == 'lg') => '75vw',
    () => '100vw'
) }}
```

| Goal | Antlers {.w-96} |
|------|---------|
| One of two values inline | `{{ is_sold ? "sold" : "for sale" }}` |
| This value, or a fallback if it's empty | `{{ nickname ?: "Friend" }}` |
| First value that isn't empty | `{{ meta_title ?? title ?? "..." }}` |
| First value that isn't `null` (keeps `0`, `false`, `''`) | `{{ power_level ??? "Over 9000" }}` |
| Only run this if it's truthy, using the [Gatekeeper](/frontend/antlers#gatekeeper) | `{{ show_bio ?= author:bio }}` |

A variable is **falsy** when it doesn't exist, is an empty string, or is an empty array or object. That means you can skip the existence check and just open the tag pair when looping over data. See [truthy and falsy](/frontend/antlers#truthy-and-falsy).

Also available: `==` `===` `!=` `!==` `>` `<` `>=` `<=` `<=>`, and `&&` `||` `!` `xor` (or the words `and` / `or` / `not`). See [comparison](/frontend/antlers#comparison) and [logical](/frontend/antlers#logical) operators.

Antlers does [math](/frontend/antlers#math) too: `+` `-` `*` `/` `%`, plus `**` for exponents and a trailing `!` for factorials. The [assignment](/frontend/antlers#assignment) forms (`+=`, `-=`, `*=`, `/=`, `%=`) all work as you'd expect.

## Modifiers

Piped, left to right, so order matters.

``` antlers
{{ title | upper }}
{{ title | upper | ensure_right('rocks!') }}

{{# Arguments go in parens; omit them if there are none #}}
{{ summary | replace('worst', 'best') }}
{{ price | format_number(2) }}
{{ tags | join(', ') }}
{{ title | replace(find, with) }}
```

Reached for constantly: [`format`](/modifiers/format), [`sanitize`](/modifiers/sanitize), [`markdown`](/modifiers/markdown), [`limit`](/modifiers/limit), [`count`](/modifiers/count), [`join`](/modifiers/join), [`slugify`](/modifiers/slugify), [`excerpt`](/modifiers/excerpt), [`raw`](/modifiers/raw).

There are [over 150 of them](/modifiers/all-modifiers), and you can [write your own](/modifiers/modifiers) or combine several into one with a [`macro`](/modifiers/macro).

## Reshaping arrays

These are operators, not modifiers, and they shine in assignments.

``` antlers
{{ articles = favorites merge everything_else }}
{{ people = people orderby (age 'desc', last_name 'asc') }}
{{ bulls  = players where (team == "Chicago Bulls") }}
{{ afford = products where (x => x.price < budget) }}
{{ top    = players take (2) }}
{{ rest   = players skip (2) }}
{{ names  = players pluck ('name') }}

{{# groupby gives you key and values #}}
{{ items = players groupby (team) }}
    <h2>{{ key }}</h2>
    {{ values }} {{ name }} {{ /values }}
{{ /items }}
```

:::best-practice
If a tag already does the job, let it. `{{ collection from="headlines|news" }}` is less code than merging two collection tags together, and it's usually faster too.
:::

Modifiers cover a lot of the same ground if you'd rather stay in a pipe: [`sort`](/modifiers/sort), [`where`](/modifiers/where), [`group_by`](/modifiers/group_by), [`key_by`](/modifiers/key_by), [`pluck`](/modifiers/pluck), [`unique`](/modifiers/unique), [`chunk`](/modifiers/chunk), [`sum`](/modifiers/sum), [`keys`](/modifiers/keys), [`values`](/modifiers/values).

They aren't drop-in replacements, though, and some operators behave slightly differently than similarly named modifiers. For more details see [advanced operators](/frontend/antlers#advanced-operators).

## Tags and parameters

Tags usually come in pairs, because they're normally fetching something and looping the results.

``` antlers
{{ collection:blog }}
    <h2>{{ title }}</h2>
{{ /collection:blog }}

{{# Some can self-close instead #}}
{{ partial:hero /}}
```

Parameters are where most of the syntax lives:

``` antlers
{{# Drop a variable into a parameter with single braces #}}
{{ nav from="{segment_1}/{segment_2}" }}

{{# Logic works in there too #}}
{{ collection:blog limit="{entry_limit ?? 10}" }}

{{# Pass a variable by name #}}
{{ nav :from="segment_1" }}

{{# Shorthand, for when the parameter and variable share a name #}}
{{ collection:blog :$id }}

{{# void drops the parameter as though you never typed it #}}
{{ svg src="menu" class="{wide ? 'w-full' : void}" }}

{{# Say "this is a tag, not a variable" #}}
{{ %collection:blog }}
```

More: [tag parameters](/frontend/antlers#tag-parameters), [shorthand syntax](/frontend/antlers#shorthand-parameter-syntax), [the full tag list](/tags/all-tags).

## Templates

The one-liners:

| Goal | Antlers {.w-96} |
|------|---------|
| Render a template's contents in a layout | `{{ template_content }}` |
| Include a view | `{{ partial:footer }}` |
| Include one that might not exist | `{{ partial:if_exists src="blog/card" }}` |
| Pass data to a partial | `{{ partial:blog/card mode="stacked" }}` |
| Render everything pushed onto a stack | `{{ stack:scripts }}` |

Some helpful things you may need when building your frontend:

``` antlers
{{# Pass markup into a partial, which reads it as {{ slot }} #}}
{{ partial:modal }}
    <h2>50% off everything!</h2>
{{ /partial:modal }}

{{# Named slots work in partials, too #}}
{{ partial:modal }}
    {{ slot:header }}<h2>Sale</h2>{{ /slot:header }}
    Everything must go.
{{ /partial:modal }}

{{# Send markup to a stack elsewhere, usually in the layout's head #}}
{{ push:scripts }}
    <script src="/js/map.js"></script>
{{ /push:scripts }}

{{# Same, but adds it to the beginning of the stack #}}
{{ prepend:scripts }}
    <script src="/js/polyfill.js"></script>
{{ /prepend:scripts }}

{{# Runs once per request, no matter how many times it's reached #}}
{{ once }}
    <link rel="stylesheet" href="/css/gallery.css">
{{ /once }}

{{# A layout region that a template can override... #}}
{{ yield:footer }}
    <p>The usual footer</p>
{{ /yield:footer }}

{{# ...and the template overriding it #}}
{{ section:footer }}
    <p>A special footer, just this once</p>
{{ /section:footer }}
```

More: [partials](/frontend/antlers#partials), [slots](/frontend/antlers#slots), [stacks](/frontend/antlers#stacks), [section & yield](/frontend/antlers#section--yield).

## Escaping and preventing parsing

Antlers does **not** escape most output automatically. Be sure to escape anything a user typed.

| Goal | Antlers {.w-96} |
|------|---------|
| Escape user input | `{{ comment \| sanitize }}` |
| Render braces instead of parsing them | `Look at that @{{ noun }}!` |
| Escape a single brace | `{{ "class='@{active@}'" }}` |
| Leave a whole parameter alone | `{{ form:create \x-data="{ open: false }" }}` |
| Leave a whole block alone | `{{ noparse }}{{ vue_thing }}{{ /noparse }}` |

More: [escaping](/frontend/antlers#escaping), [prevent parsing](/frontend/antlers#prevent-parsing).

:::tip
Antlers inside your **content** isn't parsed at all unless the field's blueprint sets `antlers: true`, and even then it runs in a hardened mode where most data-fetching tags are switched off. If `{{ collection }}` or `{{ nav }}` does nothing in a content field, that's why. See [opting into tags and modifiers](/frontend/antlers#allowing-tags-and-modifiers-in-content).
:::

## Writing PHP

``` antlers
{{? $register = route('account.register'); ?}}
<a href="{{ $register }}">Register</a>

{{# Same thing, echoed inline #}}
<a href="{{$ route('account.register') $}}">Register</a>

{{# Cascade data is reachable #}}
{{? $page->title ?}}
{{? $globals->get('company_address') ?}}
```

## Debugging

| Goal | Antlers {.w-96} |
|------|---------|
| See everything in the current context | `{{ dump }}` |
| See one value | `{{ title \| dump }}` |
| Check what type something is | `{{ price \| type_of }}` |
| Send it to Ray | `{{ entry \| ray }}` |
| Send it to the browser console | `{{ cart \| console_log }}` |
| See what's in the session | `{{ session:dump }}` |

`{{ dump }}` only outputs when `APP_DEBUG` is `true`; add `force="true"` to override. For slow pages, the [Antlers profiler](/frontend/antlers#debugbar-profiler) in the Debugbar shows which expressions are costing you the most.

## Naming is hard

| You might search for | Antlers calls it |
|----------------------|------------------|
| associative array, hash, map, object | a **dictionary** on the [Antlers page](/frontend/antlers#dictionaries) |
| `$loop`, loop counter, iteration index | [loop variables](/frontend/antlers#loop-variables) |
| include, import | [`{{ partial }}`](/tags/partial) |
| extends, block | [section & yield](/frontend/antlers#section--yield) |
| filter, pipe function | [modifier](/frontend/antlers#modifiers) |
| raw, unescaped output | the default. See [escaping](/frontend/antlers#escaping) |
| `elif`, `else if` | `elseif` |
| `foreach` over a list | just open the tag pair: `{{ songs }} ... {{ /songs }}`. [`{{ foreach }}`](/tags/foreach) is for **associative arrays** |
| a `switch` statement | the [`switch()` operator](/frontend/antlers#switch). The [`{{ switch }}` tag](/tags/switch) is unrelated, and cycles through values in a loop |
