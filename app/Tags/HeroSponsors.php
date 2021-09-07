<?php

namespace App\Tags;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\LazyCollection;
use Statamic\Support\Arr;
use Statamic\Tags\Tags;

class HeroSponsors extends Tags
{
    public function index()
    {
        return Cache::remember('hero-sponsors', now()->addHour(), function () {
            try {
                return $this->sponsors()->collect()->where('price', '>=', 100);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
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
                'variables' => ['cursor' => $cursor]
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
