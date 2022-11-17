<?php

namespace App\Tags;

use Statamic\Facades\Data;
use Illuminate\Support\Str;

class GithubCommitsUrl extends \Statamic\Tags\Tags
{
    private $endpoint = 'https://github.com/statamic/docs/commits/master/content/';

    public function index()
    {
        if (! $id = $this->context->get('id')) {
            return false;
        }

        $content = Data::find($id);

        if ($content instanceof \Statamic\Taxonomies\LocalizedTerm) {
            return;
        }

        $path = Str::after($path = $content->path(), 'content/');

        return $this->endpoint . $path;
    }
}
