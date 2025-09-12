<?php

namespace App\Modifiers;

use Illuminate\Support\Facades\Blade;
use Statamic\Facades\Markdown;
use Statamic\Modifiers\Modifier;

class ComponentSnippets extends Modifier
{
    public function index($value, $params, $context)
    {
        if (! is_string($value)) {
            return $value;
        }

        // Replace ```component...``` blocks with partial calls
        $replaced = preg_replace_callback(
            '/```component\n(.*?)\n```/s',
            function ($matches) {
                $code = $matches[1];
                $code = preg_replace('/<br\s*\/?>/i', '', $code);
                $code = trim($code);
                $url = '/cp/ui-component/'.base64_encode($code);

                return Blade::render('partials.component-example', ['code' => $code, 'url' => $url]);
            },
            $value
        );

        return Markdown::parse($replaced);
    }
}
