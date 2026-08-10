<?php

namespace App\Http\Controllers;

class RobotsTxtController extends Controller
{
    /**
     * AI crawlers we name explicitly. The policy is the same as the wildcard group,
     * but stating it per-agent makes our stance unambiguous to both operators and
     * agent-readiness scanners. Content-Signal is not inherited from `*`, so any
     * agent listed here needs the directive repeated in its own group.
     */
    private array $aiCrawlers = [
        'GPTBot',
        'OAI-SearchBot',
        'ChatGPT-User',
        'ClaudeBot',
        'Claude-User',
        'Claude-SearchBot',
        'PerplexityBot',
        'Google-Extended',
        'Applebot-Extended',
        'meta-externalagent',
        'Bytespider',
        'CCBot',
    ];

    public function __invoke()
    {
        $version = config('docs.version');

        $lines = [
            "# Statamic {$version} Documentation",
            '#',
            '# Machine-readable index: /llms.txt',
            '# Every page is also available as Markdown by appending .md to its URL,',
            '# e.g. /tags/collection.md — far cheaper to read than the HTML.',
            '',
            'User-agent: *',
            'Allow: /',
            $this->contentSignals(),
            '',
        ];

        foreach ($this->aiCrawlers as $crawler) {
            $lines[] = "User-agent: {$crawler}";
        }

        $lines[] = 'Allow: /';
        $lines[] = $this->contentSignals();
        $lines[] = '';
        $lines[] = 'Sitemap: '.url('/sitemap.xml');
        $lines[] = '';

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }

    /**
     * Content Signals (https://contentsignals.org) declare how this content may be used.
     * The docs are open source, and models knowing Statamic is good for Statamic, so we
     * permit all three uses.
     */
    private function contentSignals(): string
    {
        return 'Content-Signal: search=yes, ai-input=yes, ai-train=yes';
    }
}
