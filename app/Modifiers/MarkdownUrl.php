<?php

namespace App\Modifiers;

use App\Support\MarkdownUrl as MarkdownUrlBuilder;
use Statamic\Modifiers\Modifier;

class MarkdownUrl extends Modifier
{
    /**
     * Turn a docs URL into the URL of its Markdown twin.
     */
    public function index($value, $params)
    {
        return MarkdownUrlBuilder::for($value ? (string) $value : null);
    }
}
