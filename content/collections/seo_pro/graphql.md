---
id: 3178acd7-e001-421c-8011-291e8989e6dd
blueprint: seo_pro
title: GraphQL
---
If you're accessing content through Statamic's [GraphQL API](/graphql), you can render SEO meta on your entries and terms this way as well. For example, in an [entries query](/graphql#entries-query) you can access prerendered SEO meta `html` under `seo`:

```graphql
{
    entries {
        data {
            seo {
                html
            }
        }
    }
}
```

Or if you prefer to render your own SEO meta HTML by hand, you can access the SEO Cascade directly (which will respect your [Site Defaults](site-defaults) and [Section Defaults](#section-defaults)):

```graphql
{
    entries {
        data {
            seo {
                site_name
                site_name_position
                site_name_separator
                title
                compiled_title
                description
                priority
                change_frequency
                og_title
                canonical_url
                alternate_locales {
                    url
                    site {
                        handle
                        locale
                    }
                }
                prev_url
                next_url
                home_url
                humans_txt
                twitter_card
                twitter_handle
                image {
                    url
                    permalink
                }
                last_modified(format: "Y-m-d")
            }
        }
    }
}
```

:::tip
Feel free to browse the schema and test output through the GraphiQL explorer in your CP at `/cp/graphiql`.
:::