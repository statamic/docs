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

        // Off-site links and non-HTTP schemes have no Markdown twin.
        if (preg_match('/^([a-z][a-z0-9+.-]*:|\/\/)/i', $url)) {
            return null;
        }

        [$path, $suffix] = array_pad(preg_split('/(?=[#?])/', $url, 2), 2, '');
        $path = rtrim($path, '/');

        // The home page can't take a ".md" suffix, so it lives at /index.md — which is the
        // convention agents guess anyway.
        if ($path === '') {
            return url('/index.md').$suffix;
        }

        if (! str_ends_with($path, '.md')) {
            $path .= '.md';
        }

        return url($path).$suffix;
    }
}
