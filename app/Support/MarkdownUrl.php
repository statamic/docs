<?php

namespace App\Support;

/**
 * Maps a docs URL to its Markdown twin, served by DocsMarkdownController.
 *
 * Deliberately not a computed value: resolving an entry's URL during augmentation
 * re-enters augmentation through Statamic's redirect resolution and blows the stack.
 */
class MarkdownUrl
{
    public static function for(?string $url): ?string
    {
        if (! $url) {
            return null;
        }

        // Off-site links (ui.statamic.dev, YouTube) have no Markdown twin.
        if (str_starts_with($url, 'http')) {
            return null;
        }

        // The home page can't take a ".md" suffix, so it lives at /index.md — which is the
        // convention agents guess anyway.
        return $url === '/' ? url('/index.md') : url($url).'.md';
    }
}
