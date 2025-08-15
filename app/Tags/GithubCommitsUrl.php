<?php

namespace App\Tags;

use Statamic\Facades\Data;
use Illuminate\Support\Str;

class GithubCommitsUrl extends \Statamic\Tags\Tags
{
    public function index()
    {
        if (! $id = $this->context->get('id')) {
            return false;
        }

        $content = Data::find($id);

        if ($content instanceof \Statamic\Taxonomies\LocalizedTerm) {
            return;
        }

        $path = Str::after($content->path(), 'content/');

        return "https://github.com/statamic/docs/commits/{$this->getCurrentBranch()}/content/{$path}";
    }

    private function getCurrentBranch(): string
    {
        return collect(config('docs.versions'))
            ->where('version', config('docs.version'))
            ->first()['branch'] ?? '5.x';
    }
}
