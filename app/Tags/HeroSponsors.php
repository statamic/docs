<?php

namespace App\Tags;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\LazyCollection;
use Statamic\Support\Arr;
use Statamic\Tags\Tags;

/**
 * The homepage's sponsors list is pulled from GitHub's Sponsors GraphQL API, which requires
 * a `GITHUB_TOKEN` in your `.env`. The `statamic` org doesn't allow personal access tokens,
 * so this must be a user access token from an OAuth App authorized by an org owner:
 *
 * 1. OAuth app should be created (it is) in the `statamic` org.
 * 2. A statamic org owner visit `https://github.com/login/oauth/authorize?client_id={client_id}&scope=read:org`
 * 3. After authorizing, GitHub redirects to `http://localhost/?code={code}`. The page won't load — just copy the `code` from the URL.
 * 4. Exchange the code for a token:
 * ```
 * curl -X POST https://github.com/login/oauth/access_token \
 *   -H "Accept: application/json" \
 *   -d "client_id={client_id}&client_secret={client_secret}&code={code}"
 * ```
 * 5. Put the returned `access_token` into `GITHUB_TOKEN` in your `.env`.
 *
 * Classic OAuth App tokens don't expire, so this is a one-time setup.
 */
class HeroSponsors extends Tags
{
    public function index()
    {
        return Cache::remember('hero-sponsors', now()->addHour(), function () {
            try {
                return $this->sponsors()->collect()->where('price', '>=', 25);
            } catch (\Exception $e) {
                Log::error($e);

                return collect(['error' => true]);
            }
        });
    }

    private function sponsors()
    {
        return LazyCollection::make(function () {
            $cursor = null;

            do {
                $data = $this->request($cursor);
                $sponsorships = Arr::get($data, 'data.viewer.organization.sponsorshipsAsMaintainer');
                $cursor = $sponsorships['pageInfo']['endCursor'];
                $hasNextPage = $sponsorships['pageInfo']['hasNextPage'];

                yield from collect($sponsorships['nodes'])->map(fn ($sponsorship) => array_merge(
                    $sponsorship['sponsorEntity'],
                    ['price' => $sponsorship['tier']['monthlyPriceInDollars']]
                ));
            } while ($hasNextPage && $cursor);
        });
    }

    private function request($cursor)
    {
        return Http::baseUrl('https://api.github.com')
            ->withToken(config('services.github.token'))
            ->asJson()
            ->accept('application/vnd.github.v4+json')
            ->withUserAgent('statamic/docs')
            ->post('/graphql', [
                'query' => $this->query(),
                'variables' => ['cursor' => $cursor],
            ])
            ->json();
    }

    private function query()
    {
        return <<<'GQL'
query($cursor: String) {
    viewer {
        organization(login: "statamic") {
            sponsorshipsAsMaintainer(first: 100, after: $cursor, orderBy: {direction: ASC, field: CREATED_AT}) {
                pageInfo {
                    hasNextPage
                    endCursor
                }
                nodes {
                    sponsorEntity {
                        ... on User {
                            name
                            url
                            avatarUrl(size: 80)
                        }
                        ... on Organization {
                            name
                            url
                            avatarUrl(size: 80)
                        }
                    }
                    tier {
                        name
                        monthlyPriceInDollars
                    }
                }
            }
        }
    }
}
GQL;
    }
}
