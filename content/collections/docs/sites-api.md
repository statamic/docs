---
id: 124cb9e8-b5e0-4af6-8271-98ca6b0131b4
blueprint: page
title: 'Sites API'
intro: 'We have an API that can be used to manage your Statamic Sites in your [statamic.com](https://statamic.com) account. This is most useful with our Platform Plan, which you can [contact us](https://statamic.com/support) directly about for more information.'
---

## Authentication

To access the sites API, you'll need to create a token in your statamic.com account. All of the following endpoints require that your request contains an `Authorization` header with your token preceded by `Bearer`.

### Example Headers

| Header Name | Header Value |
| --- | --- |
| `Authorization` | `Bearer 44\|seLDYsDrqyxS2cT8PYremnysuqrovpYHSJ1lzjb3` |
| `Accept` | `application/json` |

### Using Laravel's HTTP Facade

If you are using Laravel's `Http` facade to make your requests, you can use the `acceptJson()` and `withToken()` helper methods to make simple JSON requests with your bearer token:

```php
Http::acceptJson()
  ->withToken($token)
  ->post('https://statamic.com/api/v1/sites', $payload);
```

_*For more info, read more about [headers](https://laravel.com/docs/12.x/http-client#headers) and [bearer tokens](https://laravel.com/docs/12.x/http-client#bearer-tokens) in Laravel.*_

## Endpoints

- [Sites Index](#sites-index)
- [Create Site](#create-site)
- [Delete Site](#delete-site)

### Sites Index

#### `GET https://statamic.com/api/v1/sites`

#### Example Output

```json
{
  "data": [
    {
      "name": "Wayne's World",
      "key": "pg4x2qrly2my8dl1",
      "domains": [
        "waynesworld.ca"
      ],
      "created_at": "2021-11-19 09:32:52"
    },
    {
      "name": "Bobby's World",
      "key": "1o0xe7rzdd9wq58j",
      "domains": [
        "bobbysworld.ca"
      ],
      "created_at": "2021-11-19 09:33:10"
    }
  ]
}
```

### Create Site

#### `POST https://statamic.com/api/v1/sites`

#### Params

| Param | Required | Example |
| --- | --- | --- |
| `name` | yes | `Jurassic World` |
| `domain` | no | `jurassicworld.ca` |

#### Example Output

```json
{
  "data": {
    "name": "Jurassic World",
    "key": "pwkknrxl6y7z1n9v",
    "domains": [
      "jurassicworld.ca"
    ],
    "created_at": "2021-11-18 19:45:41"
  }
}
```

### Delete Site

#### `DELETE https://statamic.com/api/v1/sites/[your-site-key-here]`

#### Example Output

```json
{
  "message": "Site [pwkknrxl6y7z1n9v] deleted."
}
```
