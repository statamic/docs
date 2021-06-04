<?php

namespace App\Tags;

use Statamic\Facades\Data;
use Illuminate\Support\Str;

class GithubEditUrl extends \Statamic\Tags\Tags
{
    private $endpoint = 'https://github.com/statamic/docs/blob/master/content/';

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
