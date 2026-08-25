<?php

namespace App\Support;

use Illuminate\Support\Str;
use Statamic\Contracts\Entries\Entry;

/**
 * Derives a human-readable description for an entry.
 *
 * Most reference entries (modifiers, variables, resource APIs) have no `intro`, which
 * left meta descriptions, Open Graph tags and llms.txt entries empty. This falls back
 * through `intro` → `description` → the first real paragraph of the body so every page
 * says something useful about itself.
 */
class Description
{
    private const MAX_LENGTH = 160;

    public static function for(Entry $entry): string
    {
        foreach (['intro', 'description'] as $field) {
            if ($value = $entry->value($field)) {
                return self::tidy(self::stripInlineMarkdown($value));
            }
        }

        return self::tidy(self::firstParagraph((string) $entry->value('content')));
    }

    /**
     * Pull the first prose paragraph out of a raw Markdown body.
     *
     * Deliberately works on the raw Markdown rather than rendered HTML: these pages are
     * code-heavy, and rendering first would mean fighting Torchlight's syntax highlighting
     * markup to get back to plain text.
     */
    public static function firstParagraph(string $markdown): string
    {
        if (trim($markdown) === '') {
            return '';
        }

        $markdown = self::stripBlocks($markdown);

        foreach (preg_split('/\n\s*\n/', $markdown) as $paragraph) {
            $paragraph = trim($paragraph);

            if ($paragraph === '' || self::isNotProse($paragraph)) {
                continue;
            }

            return self::stripInlineMarkdown($paragraph);
        }

        return '';
    }

    /**
     * Remove block-level constructs that never make sense in a description: fenced code,
     * HTML, and the custom `::tabs` / `:::tip` syntax handled by our CommonMark extensions
     * in app/Markdown.
     */
    private static function stripBlocks(string $markdown): string
    {
        $patterns = [
            '/^```.*?^```/ms',      // fenced code blocks
            '/^~~~.*?^~~~/ms',      // alternate fence
            '/^::tabs.*?^::\/tabs/ms', // tabbed code blocks (fully closed)
            '/^::tab[^\n]*$/m',     // stray tab markers
            '/^::\/?tabs?[^\n]*$/m',
            '/^:{3,}[^\n]*$/m',     // hint block delimiters (:::tip, :::warning, :::)
            // Headings are dropped line-by-line rather than as whole paragraphs: plenty of
            // pages open with a heading on the line directly above their first prose, with no
            // blank line between them.
            '/^#{1,6}[ \t][^\n]*$/m',
            '/^<[^\n]*>$/m',        // standalone HTML lines
            '/^\{\{.*?\}\}$/ms',    // Antlers left in content
        ];

        return preg_replace($patterns, '', $markdown) ?? $markdown;
    }

    /**
     * Lines that are structural rather than prose — headings, list items, tables,
     * blockquotes, images and indented code.
     */
    private static function isNotProse(string $paragraph): bool
    {
        return (bool) preg_match('/^(#|>|\||[-*+]\s|\d+\.\s|!\[|    |\t)/', $paragraph);
    }

    private static function stripInlineMarkdown(string $text): string
    {
        $replacements = [
            '/!\[[^\]]*\]\([^)]*\)/' => '',      // images
            '/\[([^\]]+)\]\([^)]*\)/' => '$1',   // links → their text
            '/`([^`]+)`/' => '$1',               // inline code
            '/\*\*([^*]+)\*\*/' => '$1',         // bold
            '/(?<!\w)[*_]([^*_]+)[*_](?!\w)/' => '$1', // italics
            '/<[^>]+>/' => '',                   // inline HTML
        ];

        return preg_replace(array_keys($replacements), array_values($replacements), $text) ?? $text;
    }

    private static function tidy(string $text): string
    {
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);

        // Many paragraphs are lead-ins to a code block ("...use the following Facade:").
        // The trailing colon dangles once the code is gone.
        $text = rtrim($text, ':');

        return Str::limit($text, self::MAX_LENGTH, '…', preserveWords: true);
    }
}
