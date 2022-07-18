---
id: 8ecc72e1-f1b7-4708-bf61-8fb98073da64
blueprint: page
title: 'Account API - Sites'
---
The Sites API is used to connect to your [statamic.com](https://statamic.com) account and programmatically create sites. This is most useful for our Platform subscription plan (to learn more about this, [contact us](https://statamic.com/support)).

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

_*For more info, read more about [headers](https://laravel.com/docs/8.x/http-client#headers) and [bearer tokens](https://laravel.com/docs/8.x/http-client#bearer-tokens) in Laravel._

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
