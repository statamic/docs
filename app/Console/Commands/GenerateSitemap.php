<?php

namespace App\Console\Commands;

use DOMDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use RuntimeException;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate the public XML sitemap';

    public function handle(): int
    {
        $xml = view('sitemap')->render();

        $this->validateXml($xml);

        File::replace(public_path('sitemap.xml'), $xml);

        $this->info('Generated public/sitemap.xml');

        return self::SUCCESS;
    }

    private function validateXml(string $xml): void
    {
        $previous = libxml_use_internal_errors(true);

        try {
            $valid = (new DOMDocument)->loadXML($xml, LIBXML_NONET);
            $errors = libxml_get_errors();
        } finally {
            libxml_clear_errors();
            libxml_use_internal_errors($previous);
        }

        if (! $valid) {
            $message = trim($errors[0]->message ?? 'Unknown XML validation error.');

            throw new RuntimeException("Unable to generate sitemap: {$message}");
        }
    }
}
