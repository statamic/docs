<?php

namespace App\Http\View\Composers;

class SideNavComposer
{
    public function compose($view)
    {
        $view->with('pages', [
            [
                'title' => 'Documentation',
                'icon' => 'book',
                'url' => '/',
                'active' => empty(request()->segments())
                    || ! in_array(request()->segment(1), ['screencasts', 'knowledge-base', 'cookbook', 'extending']),
            ],
            [
                'title' => 'Screencasts',
                'icon' => 'tv',
                'url' => '/screencasts',
                'active' => request()->segment(1) === 'screencasts',
            ],
            [
                'title' => 'Knowledge Base',
                'icon' => 'help-desk',
                'url' => '/knowledge-base',
                'active' => request()->segment(1) === 'knowledge-base',
            ],
            // [
            //     'title' => 'Cookbook',
            //     'icon' => 'cookbook',
            //     'url' => '/cookbook',
            //     'active' => request()->segment(1) === 'cookbook',
            // ],
            [
                'title' => 'Extending Statamic',
                'icon' => 'tetris',
                'url' => '/extending',
                'active' => request()->segment(1) === 'extending',
            ],
        ]);
    }
}
